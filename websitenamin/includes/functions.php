<?php
// Small helpers shared by all pages.
function e(?string $v): string { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function old(string $key, string $default = ''): string { return e($_POST[$key] ?? $default); }
function clean(string $key): string { return trim((string)($_POST[$key] ?? '')); }
function checked(string $key, string $value): string { return (($_POST[$key] ?? '') === $value) ? 'checked' : ''; }
function selected(string $key, string $value): string { return (($_POST[$key] ?? '') === $value) ? 'selected' : ''; }

$ORGANIZATIONS = ['DSWD', 'Philippine Red Cross', 'UNICEF Philippines', 'World Food Programme'];
