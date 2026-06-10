<?php

declare(strict_types=1);

/**
 * Server-rendered UI components (Tailwind classes). Mirror the Next.js design:
 * full-bleed hero banner, light content sections, cards with shadow, request panel.
 */

function bs_btn_primary(): string
{
    return 'inline-flex items-center justify-center gap-2 rounded-xl bg-action px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-action-hover active:bg-action-pressed';
}

function bs_btn_secondary(): string
{
    return 'inline-flex items-center justify-center gap-2 rounded-xl border border-border-default bg-transparent px-6 py-3 text-sm font-semibold text-action transition-colors hover:border-action-hover hover:text-action-hover';
}

function bs_input(): string
{
    return 'w-full rounded-lg border border-border-subtle bg-surface3 px-4 py-3 text-sm text-white placeholder:text-t-muted focus:border-action focus:outline-none focus:ring-1 focus:ring-action';
}

function bs_label(): string
{
    return 'mb-2 block text-[13px] font-medium text-t-secondary';
}

/** Full-bleed hero banner with optional request panel below (overlapping). */
function comp_hero(array $hero, string $size = 'full', string $panelHtml = ''): void
{
    $img = trim((string) ($hero['image'] ?? ''));
    $imgSrc = $img !== '' ? media_src($img) : '';
    $pos = e($hero['imagePosition'] ?? 'center');
    $headSize = $size === 'full' ? 'text-[30px] md:text-[44px]' : 'text-[26px] md:text-[36px]';
    $shadow = $imgSrc !== '' ? '[text-shadow:0_2px_18px_rgba(3,10,24,0.9)]' : '';
    ?>
    <section class="bg-card pb-12 md:pb-14">
      <div class="relative h-[380px] w-full overflow-hidden sm:h-[460px] md:h-[600px]">
        <?php if ($imgSrc !== ''): ?>
          <img src="<?= e($imgSrc) ?>" alt="" class="absolute inset-0 h-full w-full object-cover" style="object-position: <?= $pos ?>;">
        <?php else: ?>
          <div class="pointer-events-none absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-navy via-midnight to-midnight"></div>
            <div class="absolute inset-0 opacity-[0.12]" style="background-image:linear-gradient(#244C82 1px,transparent 1px),linear-gradient(90deg,#244C82 1px,transparent 1px);background-size:40px 40px;"></div>
            <div class="absolute inset-y-0 right-0 hidden w-1/2 items-center justify-center lg:flex">
              <span class="text-action/15"><?= str_replace('class="icon"', 'class="h-52 w-52"', icon('shield')) ?></span>
            </div>
          </div>
        <?php endif; ?>

        <div class="relative z-10 h-full">
          <div class="container-bravo flex h-full flex-col justify-center">
            <div class="max-w-2xl <?= $shadow ?>">
              <?php if (!empty($hero['eyebrow'])): ?>
                <p class="mb-4 inline-flex w-fit items-center rounded-full border border-border-subtle bg-surface3/60 px-3 py-1 text-[12px] font-medium uppercase tracking-[0.14em] text-t-secondary"><?= e($hero['eyebrow']) ?></p>
              <?php endif; ?>
              <h1 class="font-bold leading-[1.08] text-white <?= $headSize ?>"><?= e($hero['headline'] ?? '') ?></h1>
              <?php if (!empty($hero['subtext'])): ?>
                <p class="mt-4 max-w-xl text-[14px] leading-relaxed text-t-secondary md:text-[16px]"><?= e($hero['subtext']) ?></p>
              <?php endif; ?>
              <?php if (!empty($hero['primaryLabel']) || !empty($hero['secondaryLabel'])): ?>
                <div class="mt-6 flex flex-wrap gap-3">
                  <?php if (!empty($hero['primaryLabel']) && !empty($hero['primaryHref'])): ?>
                    <a href="<?= e($hero['primaryHref']) ?>" class="<?= bs_btn_primary() ?>"><?= e($hero['primaryLabel']) ?></a>
                  <?php endif; ?>
                  <?php if (!empty($hero['secondaryLabel']) && !empty($hero['secondaryHref'])): ?>
                    <a href="<?= e($hero['secondaryHref']) ?>" class="<?= bs_btn_secondary() ?>"><?= e($hero['secondaryLabel']) ?></a>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <?php if ($panelHtml !== ''): ?>
        <div class="container-bravo relative z-20 -mt-12 md:-mt-16"><?= $panelHtml ?></div>
      <?php endif; ?>
    </section>
    <?php
}

function comp_section_open(?string $heading = null, ?string $intro = null, string $tone = 'light', ?string $id = null): void
{
    $bg = $tone === 'tint' ? 'bg-page' : 'bg-card';
    echo '<section ' . ($id ? 'id="' . e($id) . '" ' : '') . 'class="' . $bg . ' py-16 md:py-24"><div class="container-bravo">';
    if ($heading || $intro) {
        echo '<div class="mb-10 max-w-2xl">';
        if ($heading) {
            echo '<h2 class="text-[24px] font-semibold leading-tight text-ink md:text-[28px]">' . e($heading) . '</h2>';
        }
        if ($intro) {
            echo '<p class="mt-3 text-[15px] leading-relaxed text-ink-soft">' . e($intro) . '</p>';
        }
        echo '</div>';
    }
}

function comp_section_close(): void
{
    echo '</div></section>';
}

function comp_service_card(array $card): void
{
    $img = trim((string) ($card['image'] ?? ''));
    $imgSrc = $img !== '' ? media_src($img) : '';
    ?>
    <div class="group flex h-full flex-col overflow-hidden rounded-2xl border border-line bg-card shadow-card transition-all duration-200 hover:-translate-y-1 hover:border-action/40 hover:shadow-card-hover">
      <?php if ($imgSrc !== ''): ?>
        <div class="relative h-40 w-full overflow-hidden"><img src="<?= e($imgSrc) ?>" alt="" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"></div>
      <?php endif; ?>
      <div class="flex flex-1 flex-col p-6">
        <?php if ($imgSrc === ''): ?>
          <span class="mb-5 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-page text-action"><?= icon($card['icon'] ?? 'shield') ?></span>
        <?php endif; ?>
        <h3 class="text-[18px] font-semibold text-ink"><?= e($card['title'] ?? '') ?></h3>
        <p class="mt-2 flex-1 text-[14px] leading-relaxed text-ink-soft"><?= e($card['body'] ?? '') ?></p>
        <?php if (!empty($card['note'])): ?><p class="mt-3 text-[12px] text-ink-muted"><?= e($card['note']) ?></p><?php endif; ?>
        <?php if (!empty($card['href'])): ?>
          <a href="<?= e($card['href']) ?>" class="mt-5 inline-flex items-center gap-1 text-sm font-medium text-action hover:text-action-hover">Learn more <?= str_replace('class="icon"', 'class="h-4 w-4"', icon('arrow')) ?></a>
        <?php endif; ?>
      </div>
    </div>
    <?php
}

function comp_feature_card(array $card): void
{
    $img = trim((string) ($card['image'] ?? ''));
    $imgSrc = $img !== '' ? media_src($img) : '';
    ?>
    <div class="overflow-hidden rounded-2xl border border-line bg-card shadow-card-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
      <?php if ($imgSrc !== ''): ?>
        <div class="relative h-32 w-full overflow-hidden"><img src="<?= e($imgSrc) ?>" alt="" class="h-full w-full object-cover"></div>
      <?php endif; ?>
      <div class="p-6">
        <?php if ($imgSrc === ''): ?>
          <span class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-page text-action"><?= icon($card['icon'] ?? 'shield') ?></span>
        <?php endif; ?>
        <h3 class="text-[16px] font-semibold text-ink"><?= e($card['title'] ?? '') ?></h3>
        <p class="mt-2 text-[14px] leading-relaxed text-ink-soft"><?= e($card['body'] ?? '') ?></p>
        <?php if (!empty($card['note'])): ?><p class="mt-3 text-[12px] text-ink-muted"><?= e($card['note']) ?></p><?php endif; ?>
      </div>
    </div>
    <?php
}

/** @param array<int,array{title:string,body:string}> $steps */
function comp_steps(array $steps): void
{
    echo '<ol class="grid gap-6 md:grid-cols-3">';
    $i = 1;
    foreach ($steps as $s) {
        echo '<li class="rounded-2xl border border-line bg-card p-6 shadow-card-sm">';
        echo '<span class="flex h-9 w-9 items-center justify-center rounded-lg bg-action/10 text-[15px] font-bold text-action">' . $i . '</span>';
        echo '<h3 class="mt-4 text-[16px] font-semibold text-ink">' . e($s['title'] ?? '') . '</h3>';
        echo '<p class="mt-2 text-[14px] leading-relaxed text-ink-soft">' . e($s['body'] ?? '') . '</p>';
        echo '</li>';
        $i++;
    }
    echo '</ol>';
}

function comp_cta(array $cta): void
{
    ?>
    <section class="bg-midnight py-16 md:py-20">
      <div class="container-bravo">
        <div class="overflow-hidden rounded-2xl border border-border-default bg-gradient-to-br from-surface1 to-surface3 px-8 py-12 text-center md:px-16 md:py-16">
          <h2 class="mx-auto max-w-2xl text-[24px] font-semibold leading-tight text-white md:text-[28px]"><?= e($cta['headline'] ?? '') ?></h2>
          <?php if (!empty($cta['body'])): ?><p class="mx-auto mt-4 max-w-xl text-[15px] leading-relaxed text-t-secondary"><?= e($cta['body']) ?></p><?php endif; ?>
          <div class="mt-8 flex justify-center"><a href="<?= e($cta['href'] ?? '#') ?>" class="<?= bs_btn_primary() ?>"><?= e($cta['label'] ?? 'Start') ?></a></div>
        </div>
      </div>
    </section>
    <?php
}

/** One request-panel field (dark inputs). */
function comp_field(array $f): void
{
    $name = e($f['name']);
    $label = e($f['label']);
    $type = $f['type'] ?? 'text';
    $span = ($type === 'textarea') ? ' sm:col-span-2' : '';
    echo '<div class="' . trim($span) . '">';
    echo '<label for="' . $name . '" class="' . bs_label() . '">' . $label . '</label>';
    if ($type === 'select') {
        echo '<select id="' . $name . '" name="' . $name . '" class="' . bs_input() . ' appearance-none"><option value="">Select…</option>';
        foreach (($f['options'] ?? []) as $opt) {
            echo '<option value="' . e($opt) . '">' . e($opt) . '</option>';
        }
        echo '</select>';
    } elseif ($type === 'textarea') {
        echo '<textarea id="' . $name . '" name="' . $name . '" rows="4" class="' . bs_input() . ' resize-y"></textarea>';
    } else {
        echo '<input id="' . $name . '" name="' . $name . '" type="' . e($type) . '" class="' . bs_input() . '">';
    }
    echo '</div>';
}

/** Request panel with service tabs (posts to /request). */
function comp_request_panel(array $request, string $id = 'request'): void
{
    $tabs = $request['serviceTabs'] ?? [];
    $contact = $request['contactFields'] ?? [];
    $okRef = flash('request_ref');
    $okCode = flash('request_code');
    ?>
    <div id="<?= e($id) ?>" class="scroll-mt-24 rounded-2xl border border-border-default bg-surface1 p-5 shadow-panel md:p-7">
      <?php if ($okRef): ?>
        <div class="rounded-xl border border-border-subtle bg-surface3 p-6 text-center">
          <span class="mx-auto mb-4 inline-flex h-11 w-11 items-center justify-center rounded-full bg-action/15 text-action"><?= icon('check') ?></span>
          <h3 class="text-[16px] font-semibold text-white">Request received</h3>
          <p class="mx-auto mt-2 max-w-md text-[13px] leading-relaxed text-t-secondary">Bravo Secure will review your request before confirmation. Keep your reference and secure code to track its status.</p>
          <p class="mt-4 text-[12px] text-t-muted">Reference: <span class="font-semibold text-t-secondary"><?= e($okRef) ?></span> &nbsp;·&nbsp; Secure code: <span class="font-semibold text-t-secondary"><?= e((string) $okCode) ?></span></p>
        </div>
      <?php else: ?>
        <div class="mb-4 flex items-baseline justify-between gap-4">
          <h2 class="text-[18px] font-semibold text-white"><?= e($request['heading'] ?? 'Request Support') ?></h2>
          <a href="/manage" class="hidden text-[12px] text-action hover:text-action-hover sm:inline">Manage an existing request</a>
        </div>
        <div class="mb-5 flex flex-wrap gap-1 border-b border-border-subtle" data-tabs>
          <?php foreach ($tabs as $idx => $tab): ?>
            <button type="button" data-tab="<?= e($tab['key']) ?>" class="relative -mb-px px-4 py-3 text-[13px] font-semibold transition-colors <?= $idx === 0 ? 'text-white' : 'text-t-muted hover:text-t-secondary' ?>">
              <?= e($tab['label']) ?>
              <span class="tab-underline absolute inset-x-2 -bottom-px h-0.5 rounded-full bg-action <?= $idx === 0 ? '' : 'hidden' ?>"></span>
            </button>
          <?php endforeach; ?>
        </div>

        <form method="post" action="/request" novalidate>
          <?= csrf_field() ?>
          <input type="hidden" name="service_type" id="reqServiceType" value="<?= e($tabs[0]['key'] ?? '') ?>">
          <?php foreach ($tabs as $idx => $tab): ?>
            <div data-fields="<?= e($tab['key']) ?>" class="grid grid-cols-1 gap-4 sm:grid-cols-2 <?= $idx === 0 ? '' : 'hidden' ?>">
              <?php foreach (($tab['fields'] ?? []) as $f) comp_field($f); ?>
            </div>
          <?php endforeach; ?>

          <div class="mt-4 grid grid-cols-1 gap-4 border-t border-border-subtle pt-4 sm:grid-cols-2">
            <?php foreach ($contact as $f) comp_field($f); ?>
          </div>

          <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <button type="submit" class="<?= bs_btn_primary() ?> w-full sm:w-auto"><?= e($request['button'] ?? 'Submit Request') ?></button>
            <p class="text-[12px] leading-relaxed text-t-muted"><?= e($request['subheading'] ?? '') ?></p>
          </div>
        </form>
      <?php endif; ?>
    </div>
    <?php
}
