<style>
.admin-body {
    --admin-ink:var(--color-primary-900,#102c2a);
    --admin-green:var(--color-primary-600,#0f766e);
    --admin-mint:var(--color-primary-100,#d9eee7);
    --admin-gold:var(--color-accent-500,#c9a66b);
    --admin-paper:#fffefa;
    --admin-bg:#f7f6f1;
    --admin-line:#e3e8e0;
    --admin-muted:#60736b;
    margin:0;
    background:var(--admin-bg);
    color:var(--admin-ink);
    font-family:'Cairo',sans-serif;
    font-size:14px;
    line-height:1.7
}

.admin-body * {
    box-sizing:border-box
}

.admin-body button,.admin-body a,.admin-body input,.admin-body select,.admin-body textarea {
    -webkit-tap-highlight-color:transparent
}

.admin-body :is(a,button,input,select,textarea):focus-visible {
    outline:3px solid var(--admin-green);
    outline-offset:4px
}

.admin-body button:disabled {
    cursor:not-allowed;
    opacity:.4
}

.admin-body button:not(:disabled),.admin-body select {
    cursor:pointer
}

.admin-shell {
    display:flex;
    min-height:100dvh
}

.admin-sidebar {
    width:268px;
    flex:0 0 268px;
    background:var(--admin-ink);
    color:#eff8f5;
    display:flex;
    flex-direction:column;
    min-height:100dvh;
    padding:30px 18px;
    position:sticky;
    top:0;
    height:100dvh;
    overflow-y:auto
}

.admin-brand {
    display:flex;
    align-items:center;
    gap:13px;
    padding:0 12px 30px;
    border-bottom:1px solid #ffffff20
}

.admin-brand-mark {
    width:48px;
    height:48px;
    display:grid;
    place-items:center;
    border:1px solid #c9a66b70;
    color:#e5ca91;
    border-radius:16px;
    font-size:25px
}

.admin-brand strong {
    font-size:26px;
    line-height:1.3;
    display:block
}

.admin-brand small {
    display:block;
    color:#b2c8c0;
    font-size:11px;
    margin-top:4px
}

.admin-nav-caption {
    color:#a6bfb5;
    font-size:11px;
    padding:28px 16px 12px
}

.admin-nav {
    display:grid;
    gap:8px
}

.admin-nav-link {
    display:flex;
    align-items:center;
    gap:13px;
    border:1px solid transparent;
    border-radius:13px;
    padding:13px 15px;
    transition:background .18s,color .18s
}

.admin-nav-link>i {
    font-size:18px;
    width:22px;
    color:#a3c1b5
}

.admin-nav-link strong {
    font-size:13px;
    font-weight:600;
    display:block
}

.admin-nav-link small {
    font-size:10px;
    color:#a6bfb5;
    display:block;
    margin-top:2px
}

.admin-nav-link:hover {
    background:#ffffff0c
}

.admin-nav-link.is-active {
    background:#d9eee7;
    color:var(--admin-ink)
}

.admin-nav-link.is-active i,.admin-nav-link.is-active small {
    color:#306057
}

.admin-nav-dot {
    margin-inline-start:auto;
    width:6px;
    height:6px;
    border-radius:50%;
    background:var(--admin-green)
}

.admin-sidebar-bottom {
    margin-top:auto;
    padding-top:40px
}

.admin-purpose {
    border:1px solid #ffffff1a;
    border-radius:15px;
    padding:18px;
    background:#ffffff05
}

.admin-purpose>i {
    color:#e5ca91;
    font-size:22px;
    display:block;
    margin-bottom:12px
}

.admin-purpose strong {
    font-size:13px
}

.admin-purpose p {
    color:#a6bfb5;
    font-size:11px;
    margin-top:6px;
    line-height:1.9
}

.admin-site-link {
    display:flex;
    align-items:center;
    gap:12px;
    padding:18px 14px;
    font-size:12px;
    color:#d9eee7
}

.admin-sidebar-note {
    display:block;
    color:#99b7aa;
    font-size:10px;
    padding-inline:14px
}

.admin-sidebar :is(a,button):focus-visible {
    outline-color:#e5ca91
}

.admin-workspace {
    flex:1;
    min-width:0;
    display:flex;
    flex-direction:column
}

.admin-topbar {
    min-height:88px;
    border-bottom:1px solid var(--admin-line);
    background:var(--admin-paper);
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 36px;
    gap:20px
}

.admin-topbar-start,.admin-topbar-actions {
    display:flex;
    align-items:center;
    gap:17px
}

.admin-topbar-start {
    font-size:12px;
    font-weight:600
}

.admin-breadcrumb-home,.admin-breadcrumb-divider {
    color:var(--admin-muted)
}

.admin-date {
    display:flex;
    gap:8px;
    align-items:center;
    color:var(--admin-muted);
    font-size:11px;
    white-space:nowrap
}

.admin-account {
    border-inline-start:1px solid var(--admin-line);
    padding-inline-start:20px;
    display:flex;
    align-items:center;
    gap:10px
}

.admin-account img {
    border-radius:14px;
    object-fit:cover;
    background:var(--admin-mint)
}

.admin-account strong {
    display:block;
    max-width:160px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
    font-size:12px
}

.admin-account small {
    display:block;
    color:var(--admin-muted);
    font-size:10px
}

.admin-icon-button {
    width:44px;
    height:44px;
    display:inline-grid;
    place-items:center;
    border:1px solid var(--admin-line);
    background:var(--admin-paper);
    border-radius:12px;
    color:var(--admin-ink)
}

.admin-icon-button:hover {
    background:var(--admin-mint)
}

.admin-logout {
    color:#a94736
}

.admin-menu-button {
    display:none
}

.admin-content {
    width:100%;
    max-width:1620px;
    margin-inline:auto;
    padding:34px 36px 48px;
    flex:1
}

.admin-page-heading {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:24px;
    margin-bottom:28px
}

.admin-page-kicker {
    font-size:10px;
    color:var(--admin-green);
    font-weight:700;
    margin:0 0 7px
}

.admin-page-heading h1 {
    font-size:clamp(24px,2.3vw,32px);
    font-weight:800;
    letter-spacing:-.6px;
    line-height:1.5;
    margin:0 0 8px
}

.admin-page-heading>div>p:last-child {
    font-size:12px;
    color:var(--admin-muted);
    margin:0
}

.admin-button {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    padding:11px 18px;
    min-height:44px;
    border-radius:10px;
    font-size:12px;
    font-weight:700;
    border:1px solid transparent;
    white-space:nowrap
}

.admin-button-primary {
    background:var(--admin-green);
    color:white
}

.admin-button-primary:hover {
    background:#115e59
}

.admin-button-secondary {
    background:var(--admin-paper);
    border-color:var(--admin-line);
    color:var(--admin-ink)
}

.admin-button-secondary:hover {
    border-color:var(--admin-green);
    background:#eff8f5
}

.admin-alert {
    padding:16px 20px;
    border:1px solid;
    border-radius:12px;
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:22px
}

.admin-alert-success {
    background:#eff8f5;
    border-color:#b5d8ca;
    color:#115e59
}

.admin-alert-error {
    background:#fcf0ed;
    border-color:#edc4b9;
    color:#9d3c2b
}

.admin-footer {
    display:flex;
    justify-content:space-between;
    gap:16px;
    border-top:1px solid var(--admin-line);
    padding:20px 36px;
    font-size:10px;
    color:var(--admin-muted)
}

.admin-skip {
    position:fixed;
    top:-100px;
    inset-inline-start:20px;
    z-index:100;
    background:var(--admin-paper);
    padding:12px 22px;
    border:2px solid var(--admin-green);
    border-radius:10px
}

.admin-skip:focus {
    top:12px
}

/* Shared surfaces for lists, detail pages and forms. */
.admin-content .bg-white {
    background:var(--admin-paper);
    border:1px solid var(--admin-line);
    box-shadow:0 4px 20px #102c2a03;
    border-radius:17px
}

.admin-content .bg-gray-50 {
    background:#f3f6f1
}

.admin-content :is(.text-gray-900,.text-gray-800,.text-gray-700) {
    color:var(--admin-ink)
}

.admin-content :is(.text-gray-500,.text-gray-600,.text-gray-400) {
    color:var(--admin-muted)
}

.admin-content :is(.text-blue-600,.text-blue-700,.text-purple-700) {
    color:var(--admin-green)
}

.admin-content :is(.bg-blue-100,.bg-purple-100) {
    background:var(--admin-mint)
}

.admin-content .bg-primary-600 {
    background:var(--admin-green)
}

.admin-content .bg-primary-600:hover {
    background:#115e59
}

.admin-content :is(.bg-red-500,.bg-red-600) {
    background:#a94736
}

.admin-content .bg-green-500 {
    background:#26735f
}

.admin-content .bg-yellow-500 {
    background:#936a2b
}

.admin-content :is(.text-yellow-600,.text-yellow-700) {
    color:#835e26
}

.admin-content :is(.text-green-500,.text-green-600,.text-green-700,.text-emerald-500) {
    color:#26735f
}

.admin-content :is(.text-red-500,.text-red-600,.text-red-700) {
    color:#a94736
}

.admin-content .bg-gray-100 {
    background:#edf1eb
}

.admin-content .border-gray-100,.admin-content .border-gray-200 {
    border-color:var(--admin-line)
}

.admin-table-scroll {
    overflow-x:auto;
    overscroll-behavior-inline:contain
}

.admin-content table {
    min-width:660px;
    border-collapse:collapse
}

.admin-content th {
    padding:18px 22px;
    font-size:11px;
    font-weight:700;
    text-align:start;
    white-space:nowrap;
    background:#edf2ec;
    color:#486357
}

.admin-content td {
    padding:18px 22px;
    vertical-align:middle;
    max-width:350px;
    overflow-wrap:anywhere
}

.admin-content tbody tr {
    transition:background .15s
}

.admin-content tbody tr:hover {
    background:#f4f8f2
}

.admin-content tbody tr:last-child {
    border-bottom:0
}

.admin-content td[colspan] {
    padding:64px 24px;
    text-align:center;
    font-size:14px;
    background:#fffefa
}

.admin-content td .flex.gap-2>form>button,.admin-content td .flex.gap-2>a {
    display:inline-grid;
    place-items:center;
    min-width:40px;
    min-height:40px;
    border:1px solid var(--admin-line);
    border-radius:10px;
    background:#fffefa
}

.admin-content td .flex.gap-2>form>button:hover,.admin-content td .flex.gap-2>a:hover {
    background:#eff8f5;
    border-color:#b7d0c3
}

.admin-content :is(input:not([type=checkbox]):not([type=hidden]),select,textarea) {
    min-height:46px;
    background:#fffefa;
    border:1px solid #cbd7ce;
    border-radius:10px;
    color:var(--admin-ink);
    font-family:inherit;
    font-size:13px;
    max-width:100%;
    transition:border-color .15s,box-shadow .15s
}

.admin-content input::placeholder,.admin-content textarea::placeholder {
    color:#6a7e72
}

.admin-content :is(input,select,textarea):focus {
    border-color:var(--admin-green);
    box-shadow:0 0 0 3px #0f766e18
}

.admin-content :is(input,select,textarea)[aria-invalid=true] {
    border-color:#a94736
}

.admin-content input:disabled {
    background:#edf1eb;
    color:#60736b;
    cursor:not-allowed
}

.admin-content input[type=checkbox] {
    width:18px;
    height:18px;
    accent-color:var(--admin-green)
}

.admin-content label {
    font-size:12px;
    font-weight:600;
    margin-bottom:8px
}

.admin-content form.bg-white {
    padding:30px
}

.admin-content form button[type=submit],.admin-content form button:not([type]) {
    min-height:44px
}

.admin-content form.grid {
    align-items:end
}

.admin-content form.grid button {
    padding:12px
}

.admin-content :is(.max-w-2xl,.max-w-3xl,.max-w-4xl) {
    max-width:980px;
    margin-inline:auto
}

.admin-content .space-y-4> :not([hidden])~:not([hidden]) {
    margin-top:22px
}

.admin-content .flex.gap-3.pt-4 {
    padding-top:24px;
    flex-wrap:wrap
}

.admin-content .flex.gap-3.pt-4>:is(a,button) {
    min-height:44px
}

.admin-content img {
    object-fit:cover
}

.admin-content .admin-detail-images img {
    height:160px
}

.admin-content .admin-filter-panel {
    padding:22px;
    margin-bottom:22px
}

.admin-section-heading {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:18px;
    margin-bottom:18px
}

.admin-section-heading h2 {
    font-size:16px;
    font-weight:800;
    margin:0
}

.admin-section-heading p {
    font-size:11px;
    color:var(--admin-muted);
    margin:4px 0 0
}

.admin-result-count {
    font-size:11px;
    color:var(--admin-green);
    background:var(--admin-mint);
    padding:5px 12px;
    border-radius:8px;
    white-space:nowrap
}

.admin-resource-intro {
    display:flex;
    align-items:center;
    gap:14px;
    margin-bottom:22px;
    padding:20px 24px;
    border:1px solid var(--admin-line);
    border-radius:15px;
    background:#edf3ec
}

.admin-resource-intro>i {
    font-size:22px;
    color:var(--admin-green)
}

.admin-resource-intro strong {
    font-size:14px;
    display:block
}

.admin-resource-intro p {
    margin:4px 0 0;
    font-size:12px;
    color:var(--admin-muted)
}

.admin-form-title {
    margin-bottom:22px;
    padding-bottom:18px;
    border-bottom:1px solid var(--admin-line)
}

.admin-form-title h2 {
    font-size:17px;
    font-weight:800
}

.admin-form-title p {
    font-size:12px;
    color:var(--admin-muted);
    margin-top:4px
}

.admin-field-error {
    font-size:12px;
    color:#a94736;
    margin-top:6px
}

.admin-table-caption {
    padding:18px 22px;
    text-align:start;
    font-size:14px;
    font-weight:700;
    color:var(--admin-ink);
    border-bottom:1px solid var(--admin-line)
}

.admin-table-caption small {
    font-weight:400;
    color:var(--admin-muted);
    margin-inline-start:10px;
    font-size:11px
}

/* Overview prioritizes moderation and actual platform data. */
.admin-overview-banner {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    background:var(--admin-ink);
    color:#eff8f5;
    border-radius:19px;
    padding:28px 30px;
    margin-bottom:24px;
    position:relative;
    overflow:hidden
}

.admin-overview-banner:after {
    content:'';
    position:absolute;
    inset-inline-end:180px;
    top:-70px;
    width:260px;
    height:260px;
    border:1px solid #d9eee718;
    border-radius:50%;
    pointer-events:none
}

.admin-overview-banner h2 {
    font-size:22px;
    font-weight:700;
    margin:0 0 8px
}

.admin-overview-banner p {
    color:#bbd3c8;
    font-size:12px;
    margin:0;
    max-width:620px
}

.admin-overview-banner .admin-button {
    background:#d9eee7;
    color:var(--admin-ink);
    position:relative;
    z-index:1
}

.admin-overview-banner .admin-button:hover {
    background:#fffefa
}

.admin-stats-grid {
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:18px;
    margin-bottom:24px
}

.admin-stat {
    padding:22px;
    background:var(--admin-paper);
    border:1px solid var(--admin-line);
    border-radius:15px;
    display:block;
    transition:border-color .18s
}

.admin-stat:hover {
    border-color:#94b9a7
}

.admin-stat-top {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px
}

.admin-stat-top>span {
    font-size:12px;
    color:var(--admin-muted);
    font-weight:600
}

.admin-stat-icon {
    width:38px;
    height:38px;
    display:grid;
    place-items:center;
    color:var(--admin-green);
    border-radius:12px;
    background:#eff8f5
}

.admin-stat-value {
    font-size:36px;
    line-height:1.4;
    letter-spacing:-1px;
    font-weight:800;
    display:block;
    margin-top:14px;
    font-variant-numeric:tabular-nums
}

.admin-stat-foot {
    display:flex;
    align-items:center;
    gap:7px;
    font-size:10px;
    color:var(--admin-muted);
    margin-top:10px
}

.admin-stat-foot i {
    color:var(--admin-green)
}

.admin-analysis-grid {
    display:grid;
    grid-template-columns:minmax(0,1.6fr) minmax(0,1fr);
    gap:22px;
    margin-bottom:24px
}

.admin-panel {
    background:var(--admin-paper);
    border:1px solid var(--admin-line);
    border-radius:17px;
    padding:24px;
    min-width:0
}

.admin-chart-wrap {
    position:relative;
    height:280px
}

.admin-chart-summary {
    display:flex;
    gap:20px;
    flex-wrap:wrap;
    margin-bottom:18px;
    font-size:11px;
    color:var(--admin-muted)
}

.admin-chart-summary span {
    display:flex;
    align-items:center;
    gap:7px
}

.admin-chart-dot {
    width:8px;
    height:8px;
    background:var(--admin-green);
    border-radius:50%
}

.admin-chart-fallback {
    color:var(--admin-muted);
    font-size:12px;
    text-align:center;
    padding:65px 10px
}

.admin-lower-grid {
    display:grid;
    grid-template-columns:minmax(0,1.6fr) minmax(0,1fr);
    gap:22px
}

.admin-distribution {
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:14px;
    margin-top:22px
}

.admin-distribution>div {
    background:#f3f6f1;
    border-radius:12px;
    padding:18px
}

.admin-distribution span {
    font-size:11px;
    color:var(--admin-muted);
    display:block
}

.admin-distribution strong {
    font-size:25px;
    font-weight:800;
    display:block;
    margin-top:5px
}

.admin-progress-track {
    height:8px;
    border-radius:20px;
    background:#e8ede5;
    overflow:hidden;
    margin-top:22px
}

.admin-progress-track span {
    display:block;
    height:100%;
    background:var(--admin-green);
    border-radius:20px
}

.admin-progress-caption {
    display:flex;
    justify-content:space-between;
    gap:10px;
    margin-top:9px;
    font-size:11px;
    color:var(--admin-muted)
}

.admin-quick-links {
    display:grid;
    gap:2px
}

.admin-quick-links a {
    display:flex;
    gap:12px;
    align-items:center;
    padding:14px 0;
    border-bottom:1px solid var(--admin-line)
}

.admin-quick-links a:last-child {
    border:0;
    padding-bottom:0
}

.admin-quick-links a>i:first-child {
    width:36px;
    height:36px;
    display:grid;
    place-items:center;
    border-radius:11px;
    background:#eff8f5;
    color:var(--admin-green)
}

.admin-quick-links a>i:last-child {
    margin-inline-start:auto;
    font-size:11px;
    color:var(--admin-muted)
}

.admin-quick-links strong {
    display:block;
    font-size:12px
}

.admin-quick-links small {
    font-size:10px;
    color:var(--admin-muted)
}

.admin-quick-links a:hover strong {
    color:var(--admin-green)
}

.admin-data-summary {
    margin-top:15px
}

.admin-data-summary summary {
    cursor:pointer;
    color:var(--admin-green);
    font-size:11px;
    padding:8px 0
}

.admin-data-summary dl {
    display:grid;
    grid-template-columns:1fr auto;
    gap:5px 20px;
    font-size:11px;
    color:var(--admin-muted);
    max-height:160px;
    overflow:auto
}

.admin-data-summary dd {
    font-weight:700;
    color:var(--admin-ink)
}

@media(min-width:1500px) {
    .admin-content {
        padding-inline:48px
    }
    .admin-topbar {
        padding-inline:48px
    }
    .admin-sidebar {
        width:284px;
        flex-basis:284px
    }
}

@media(max-width:1199px) {
    .admin-sidebar {
        width:232px;
        flex-basis:232px;
        padding-inline:12px
    }
    .admin-content {
        padding:28px 24px
    }
    .admin-topbar {
        padding-inline:24px
    }
    .admin-date {
        display:none
    }
    .admin-stat {
        padding:18px
    }
    .admin-stat-value {
        font-size:30px
    }
    .admin-analysis-grid,.admin-lower-grid {
        grid-template-columns:minmax(0,1.3fr) minmax(0,1fr)
    }
}

@media(max-width:900px) {
    .admin-shell {
        display:block
    }
    .admin-sidebar {
        position:static;
        min-height:0;
        width:auto;
        height:auto;
        padding:16px 20px;
        overflow:visible
    }
    .admin-brand {
        padding:0 0 15px
    }
    .admin-brand strong {
        font-size:22px
    }
    .admin-brand-mark {
        width:40px;
        height:40px;
        font-size:21px
    }
    .admin-nav-caption,.admin-sidebar-bottom {
        display:none
    }
    .admin-nav {
        display:flex;
        flex-wrap:wrap;
        gap:6px;
        padding-top:14px
    }
    .admin-nav-link {
        padding:10px 12px;
        flex:1;
        justify-content:center;
        gap:8px;
        white-space:nowrap
    }
    .admin-nav-link small,.admin-nav-dot {
        display:none
    }
    .admin-nav-link>i {
        width:auto;
        font-size:15px
    }
    .admin-topbar {
        min-height:72px
    }
    .admin-account {
        border:0;
        padding:0
    }
    .admin-account span {
        display:none
    }
    .admin-stats-grid {
        grid-template-columns:repeat(2,minmax(0,1fr))
    }
    .admin-analysis-grid,.admin-lower-grid {
        grid-template-columns:1fr
    }
    .admin-chart-wrap {
        height:280px
    }
}

@media(max-width:600px) {
    .admin-sidebar {
        padding:16px
    }
    .admin-brand {
        border:0;
        padding:0
    }
    .admin-nav {
        display:grid;
        grid-template-columns:1fr;
        padding-top:18px
    }
    .admin-nav-link {
        justify-content:start;
        min-height:48px
    }
    .admin-nav-link small {
        display:block
    }
    .admin-body.admin-navigation-ready .admin-nav {
        display:none
    }
    .admin-body.admin-navigation-open .admin-nav {
        display:grid
    }
    .admin-menu-button {
        display:inline-grid
    }
    .admin-content {
        padding:24px 16px 34px
    }
    .admin-topbar {
        padding:12px 16px;
        gap:10px
    }
    .admin-topbar-start,.admin-topbar-actions {
        gap:9px
    }
    .admin-topbar-start {
        font-size:10px
    }
    .admin-breadcrumb-home,.admin-breadcrumb-divider {
        display:none
    }
    .admin-account img {
        width:34px;
        height:34px
    }
    .admin-icon-button {
        width:40px;
        height:44px
    }
    .admin-page-heading {
        align-items:start;
        gap:12px;
        margin-bottom:22px
    }
    .admin-page-heading>.admin-button {
        padding:9px 11px;
        font-size:10px;
        min-height:40px
    }
    .admin-page-heading>div>p:last-child {
        font-size:11px
    }
    .admin-page-kicker {
        font-size:9px
    }
    .admin-overview-banner {
        padding:22px;
        display:block
    }
    .admin-overview-banner h2 {
        font-size:19px
    }
    .admin-overview-banner .admin-button {
        margin-top:20px;
        width:100%
    }
    .admin-overview-banner:after {
        display:none
    }
    .admin-stats-grid {
        gap:12px
    }
    .admin-stat {
        padding:16px
    }
    .admin-stat-top {
        align-items:start
    }
    .admin-stat-top>span {
        font-size:11px
    }
    .admin-stat-icon {
        width:30px;
        height:30px;
        border-radius:9px;
        font-size:12px
    }
    .admin-stat-value {
        font-size:29px;
        margin-top:10px
    }
    .admin-stat-foot {
        font-size:9px;
        align-items:start
    }
    .admin-panel {
        padding:20px
    }
    .admin-section-heading h2 {
        font-size:14px
    }
    .admin-distribution {
        gap:8px
    }
    .admin-distribution>div {
        padding:12px
    }
    .admin-distribution strong {
        font-size:22px
    }
    .admin-distribution span {
        font-size:10px
    }
    .admin-footer {
        padding:18px 16px;
        font-size:9px
    }
    .admin-footer>span:last-child {
        display:none
    }
    .admin-content form.bg-white {
        padding:22px 18px
    }
    .admin-resource-intro {
        padding:18px
    }
    .admin-resource-intro p {
        font-size:11px
    }
    .admin-content table {
        min-width:620px
    }
    .admin-content th,.admin-content td {
        padding:15px 16px
    }
    .admin-content td .flex.gap-2>form>button,.admin-content td .flex.gap-2>a {
        min-width:44px;
        min-height:44px
    }
    .admin-content .admin-detail-images img {
        height:130px
    }
}

@media(prefers-reduced-motion:reduce) {
    .admin-body *,.admin-body *:before,.admin-body *:after {
        animation:none!important;
        transition:none!important;
        scroll-behavior:auto!important
    }
}

.admin-filter-field {
    min-width:0
}

.admin-filter-field label {
    display:block
}

.admin-filter-field :is(input,select) {
    width:100%
}

.admin-filter-actions {
    display:flex;
    gap:8px;
    align-items:center
}

.admin-filter-actions button {
    flex:1;
    padding-inline:16px
}

.admin-filter-actions a {
    font-size:10px;
    padding-inline:10px
}

.admin-avatar {
    width:40px;
    height:40px;
    display:grid;
    place-items:center;
    border-radius:13px;
    background:var(--admin-mint);
    color:var(--admin-green);
    font-weight:800;
    font-size:18px
}

.admin-table-scroll:focus-visible {
    outline:3px solid var(--admin-green);
    outline-offset:3px
}

.admin-content :is(input,select,textarea):focus-visible {
    outline-offset:2px
}

@media(max-width:600px) {
    .admin-filter-actions {
        flex-wrap:wrap
    }
    .admin-filter-actions>a {
        flex:1
    }
    .admin-avatar {
        width:34px;
        height:34px;
        font-size:16px
    }
}
.admin-brand-logo {
    position:relative;
    flex:0 0 52px;
    width:52px;
    height:52px;
    overflow:hidden;
    border-radius:16px;
    background:var(--admin-paper);
}

.admin-brand-logo img {
    position:absolute;
    top:0;
    left:0;
    width:233%;
    height:auto;
    max-width:none;
    transform:translate(-28.5%,-18.4%);
}

.admin-report-toolbar,.admin-report-categories {
    margin-bottom:24px;
}

.admin-report-filters {
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr)) auto auto;
    gap:16px;
    align-items:end;
}

.admin-report-filters input {
    padding:10px 14px;
}

.admin-report-note {
    display:flex;
    align-items:flex-start;
    gap:10px;
    color:var(--admin-muted);
    font-size:12px;
    line-height:1.9;
    margin-bottom:24px;
}

.admin-report-note i {
    color:var(--admin-green);
    margin-top:5px;
}

.admin-report-breakdown {
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:14px;
}

.admin-report-breakdown>div {
    padding:16px;
    border-radius:12px;
    background:#f3f6f1;
}

.admin-report-breakdown dt {
    color:var(--admin-muted);
    font-size:12px;
}

.admin-report-breakdown dd {
    font-size:25px;
    font-weight:800;
    margin-top:6px;
}

@media(max-width:1100px) {
    .admin-report-filters {
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:600px) {
    .admin-brand-logo {
        width:44px;
        height:44px;
        flex-basis:44px;
        border-radius:12px;
    }
    .admin-report-toolbar .admin-section-heading {
        align-items:flex-start;
        flex-direction:column;
    }
    .admin-report-filters {
        grid-template-columns:1fr;
    }
    .admin-account>.admin-avatar {
        display:grid;
    }
}
</style>
