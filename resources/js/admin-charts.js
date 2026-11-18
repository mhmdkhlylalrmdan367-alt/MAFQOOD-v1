import Chart from 'chart.js/auto';

const source = document.querySelector('[data-admin-charts]');
if (source) {
    const data = JSON.parse(source.textContent);
    const reducedMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;
    const tokens = getComputedStyle(document.body);
    const green = tokens.getPropertyValue('--admin-green').trim() || '#0f766e';
    Chart.defaults.font.family = 'Cairo, sans-serif';
    Chart.defaults.font.size = 11;
    Chart.defaults.color = '#60736b';
    const options = {
        responsive: true,
        maintainAspectRatio: false,
        animation: reducedMotion ? false : { duration: 350 },
        plugins: {
            legend: { display: false },
            tooltip: { rtl: document.documentElement.dir === 'rtl', backgroundColor: '#102c2a', padding: 12, cornerRadius: 8 },
        },
    };
    const monthly = document.getElementById('monthlyChart');
    if (monthly) {
        new Chart(monthly, {
            type: 'line',
            data: {
                labels: data.months,
                datasets: [{ label: 'الإعلانات', data: data.monthlyTotals, borderColor: green, backgroundColor: 'rgba(15,118,110,.07)', borderWidth: 2.5, pointRadius: 4, pointHoverRadius: 7, pointHitRadius: 20, pointBackgroundColor: '#fffefa', pointBorderWidth: 2, tension: .35, fill: true }],
            },
            options: { ...options, scales: { y: { beginAtZero: true, ticks: { precision: 0, maxTicksLimit: 6 }, border: { display: false }, grid: { color: '#e8ede5' } }, x: { grid: { display: false }, border: { display: false }, ticks: { maxRotation: 0, maxTicksLimit: 6 } } } },
        });
    }
    const categories = document.getElementById('categoryChart');
    if (categories) {
        new Chart(categories, {
            type: 'bar',
            data: { labels: data.categories, datasets: [{ label: 'الإعلانات', data: data.categoryTotals, backgroundColor: green, hoverBackgroundColor: '#115e59', borderRadius: 5, maxBarThickness: 16 }] },
            options: { ...options, indexAxis: 'y', scales: { x: { beginAtZero: true, ticks: { precision: 0, maxTicksLimit: 4 }, border: { display: false }, grid: { color: '#e8ede5' } }, y: { grid: { display: false }, border: { display: false }, ticks: { autoSkip: false } } } },
        });
    }
}
