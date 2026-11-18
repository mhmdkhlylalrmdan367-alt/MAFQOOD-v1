<?php

namespace App\Support;

use RuntimeException;
use Throwable;
use XMLWriter;
use ZipArchive;

class XlsxExport
{
    private const XMLNS = 'http://schemas.openxmlformats.org/spreadsheetml/2006/main';

    /** Write rows to temporary XML files so large exports do not accumulate in memory. */
    public function create(iterable $sheets): string
    {
        $archivePath = $this->temporaryFile();
        $files = [];
        $zip = new ZipArchive;
        $opened = false;

        try {
            if ($zip->open($archivePath, ZipArchive::OVERWRITE) !== true) {
                throw new RuntimeException('تعذر إنشاء ملف Excel.');
            }
            $opened = true;
            $workbook = '<workbook xmlns="'.self::XMLNS.'" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets>';
            $relationships = '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">';
            $types = '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>';
            $index = 0;

            foreach ($sheets as $name => $rows) {
                $index++;
                $files[] = $sheetPath = $this->temporaryFile();
                $this->writeSheet($sheetPath, $rows);
                if (! $zip->addFile($sheetPath, "xl/worksheets/sheet{$index}.xml")) {
                    throw new RuntimeException('تعذر إضافة ورقة Excel.');
                }
                $workbook .= '<sheet name="'.htmlspecialchars($name, ENT_XML1 | ENT_QUOTES, 'UTF-8').'" sheetId="'.$index.'" r:id="rId'.$index.'"/>';
                $relationships .= '<Relationship Id="rId'.$index.'" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet'.$index.'.xml"/>';
                $types .= '<Override PartName="/xl/worksheets/sheet'.$index.'.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>';
            }

            $relationships .= '<Relationship Id="styles" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>';
            $parts = [
                '[Content_Types].xml' => $types.'</Types>',
                '_rels/.rels' => '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="workbook" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>',
                'xl/workbook.xml' => $workbook.'</sheets></workbook>',
                'xl/_rels/workbook.xml.rels' => $relationships,
                'xl/styles.xml' => $this->styles(),
            ];
            foreach ($parts as $path => $xml) {
                if (! $zip->addFromString($path, '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.$xml)) {
                    throw new RuntimeException('تعذر كتابة ملف Excel.');
                }
            }
            if (! $zip->close()) {
                throw new RuntimeException('تعذر إكمال ملف Excel.');
            }
            $opened = false;

            return $archivePath;
        } catch (Throwable $exception) {
            if ($opened) {
                $zip->close();
            }
            @unlink($archivePath);
            throw $exception;
        } finally {
            foreach ($files as $file) {
                @unlink($file);
            }
        }
    }

    private function writeSheet(string $path, iterable $rows): void
    {
        $xml = new XMLWriter;
        if (! $xml->openUri($path)) {
            throw new RuntimeException('تعذر إنشاء ورقة Excel.');
        }
        $xml->startDocument('1.0', 'UTF-8', 'yes');
        $xml->startElement('worksheet');
        $xml->writeAttribute('xmlns', self::XMLNS);
        $xml->writeRaw('<sheetViews><sheetView workbookViewId="0" rightToLeft="1"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews><cols><col min="1" max="1" width="32" customWidth="1"/><col min="2" max="2" width="52" customWidth="1"/><col min="3" max="8" width="24" customWidth="1"/></cols>');
        $xml->startElement('sheetData');
        $rowNumber = 0;
        $columnCount = 1;

        foreach ($rows as $row) {
            $rowNumber++;
            if ($rowNumber > 1048576) {
                throw new RuntimeException('تجاوز التقرير حد صفوف Excel. يرجى اختيار فترة أقصر.');
            }
            $columnCount = max($columnCount, count($row));
            $xml->startElement('row');
            $xml->writeAttribute('r', (string) $rowNumber);
            foreach (array_values($row) as $column => $value) {
                $xml->startElement('c');
                $xml->writeAttribute('r', $this->columnName($column + 1).$rowNumber);
                $xml->writeAttribute('s', $rowNumber === 1 ? '1' : '0');
                if (is_int($value) || (is_float($value) && is_finite($value))) {
                    $xml->writeElement('v', (string) $value);
                } else {
                    // Explicit text cells keep user titles beginning with =, +, - or @ inert.
                    $xml->writeAttribute('t', 'inlineStr');
                    $xml->startElement('is');
                    $xml->startElement('t');
                    $xml->writeAttribute('xml:space', 'preserve');
                    $text = preg_replace('/[^\x09\x0A\x0D\x20-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', (string) $value) ?? '';
                    $xml->text(mb_substr($text, 0, 32767));
                    $xml->endElement();
                    $xml->endElement();
                }
                $xml->endElement();
            }
            $xml->endElement();
        }
        $xml->endElement();
        if ($rowNumber > 0) {
            $xml->writeRaw('<autoFilter ref="A1:'.$this->columnName($columnCount).$rowNumber.'"/>');
        }
        $xml->endElement();
        $xml->endDocument();
        $xml->flush();
    }

    private function columnName(int $number): string
    {
        $name = '';
        while ($number > 0) {
            $number--;
            $name = chr(65 + $number % 26).$name;
            $number = intdiv($number, 26);
        }

        return $name;
    }

    private function temporaryFile(): string
    {
        $file = tempnam(sys_get_temp_dir(), 'luqya-xlsx-');
        if ($file === false) {
            throw new RuntimeException('تعذر إنشاء ملف مؤقت للتقرير.');
        }

        return $file;
    }

    private function styles(): string
    {
        return '<styleSheet xmlns="'.self::XMLNS.'"><fonts count="2"><font><sz val="11"/><name val="Arial"/><color rgb="FF102C2A"/></font><font><b/><sz val="11"/><name val="Arial"/><color rgb="FFFFFFFF"/></font></fonts><fills count="3"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill><fill><patternFill patternType="solid"><fgColor rgb="FF0F766E"/><bgColor indexed="64"/></patternFill></fill></fills><borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders><cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs><cellXfs count="2"><xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0" applyAlignment="1"><alignment vertical="center" readingOrder="2"/></xf><xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1" applyAlignment="1"><alignment vertical="center" readingOrder="2"/></xf></cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>';
    }
}
