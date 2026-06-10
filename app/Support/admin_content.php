<?php

declare(strict_types=1);

/**
 * Recursive content editor helpers (admin). Renders a nested array as a form
 * using bracket field names so PHP rebuilds the structure in $_POST['c'].
 */

function bs_pretty_label(string $k): string
{
    if ($k === '') {
        return '';
    }
    $s = str_replace(['_', '-'], ' ', $k);
    $s = preg_replace('/([a-z])([A-Z])/', '$1 $2', $s) ?? $s;
    return ucfirst(trim($s));
}

function bs_is_long_key(string $k): bool
{
    return in_array(strtolower($k), ['body', 'subtext', 'intro', 'description', 'blurb', 'requirement', 'helper'], true);
}

/** @param mixed $item @return mixed */
function bs_blank_template($item)
{
    if (is_array($item)) {
        $o = [];
        foreach ($item as $k => $v) {
            $o[$k] = bs_blank_template($v);
        }
        return $o;
    }
    return '';
}

/** Does this object look like a card (so it can carry an image)? */
function bs_is_card($item): bool
{
    return is_array($item)
        && array_key_exists('title', $item) && array_key_exists('body', $item)
        && (array_key_exists('icon', $item) || array_key_exists('href', $item)
            || array_key_exists('note', $item) || array_key_exists('image', $item));
}

/** An upload control bound to a text field (the path is what gets submitted). */
function bs_image_field(string $name, string $value): void
{
    $v = trim($value);
    echo '<div class="mb-3" data-image-field>';
    echo '<label class="lbl">Image</label>';
    echo '<div class="flex items-center gap-3">';
    echo '<div class="img-preview flex h-14 w-20 shrink-0 items-center justify-center overflow-hidden rounded border border-border-subtle bg-surface3">';
    echo $v !== '' ? '<img src="' . e($v) . '" alt="" class="h-full w-full object-cover">' : '<span class="text-[10px] text-t-muted">None</span>';
    echo '</div>';
    echo '<input type="text" class="ipt img-input" name="' . e($name) . '" value="' . e($value) . '" placeholder="/assets/uploads/...">';
    echo '<label class="btnp cursor-pointer whitespace-nowrap px-3 py-2 text-[13px]">Upload<input type="file" accept="image/*" class="hidden img-file"></label>';
    echo '</div></div>';
}

/** Render one node of the content tree. */
function admin_content_node(mixed $value, string $name, string $key): void
{
    $label = bs_pretty_label($key);

    if (is_array($value)) {
        $isList = $value === [] ? false : array_is_list($value);

        echo '<fieldset class="mb-4 rounded-xl border border-border-subtle bg-surface2 p-4">';
        if ($label !== '') {
            echo '<legend class="px-1 text-[12px] font-semibold uppercase tracking-[0.1em] text-action">' . e($label) . '</legend>';
        }

        if ($isList) {
            $objects = is_array($value[0] ?? null);
            foreach ($value as $i => $item) {
                echo '<div class="mb-3 rounded-lg border border-border-subtle bg-surface3 p-4">';
                echo '<div class="mb-2 text-[12px] font-semibold text-white">' . e($label) . ' ' . ((int) $i + 1) . '</div>';
                if (is_array($item)) {
                    foreach ($item as $ik => $iv) {
                        admin_content_node($iv, $name . '[' . $i . '][' . $ik . ']', (string) $ik);
                    }
                    if (bs_is_card($item) && !array_key_exists('image', $item)) {
                        bs_image_field($name . '[' . $i . '][image]', '');
                    }
                } else {
                    admin_content_node($item, $name . '[' . $i . ']', $key);
                }
                echo '</div>';
            }
            // two blank slots for adding items
            $tpl = $objects ? bs_blank_template($value[0]) : '';
            if ($objects && bs_is_card($value[0]) && !array_key_exists('image', $tpl)) {
                $tpl['image'] = '';
            }
            for ($n = 0; $n < 2; $n++) {
                $slot = 'new' . $n;
                echo '<div class="mb-3 rounded-lg border border-dashed border-border-subtle p-4">';
                echo '<div class="mb-2 text-[12px] text-t-muted">Add new (leave blank to skip)</div>';
                if ($objects) {
                    foreach ($tpl as $ik => $iv) {
                        admin_content_node($iv, $name . '[' . $slot . '][' . $ik . ']', (string) $ik);
                    }
                } else {
                    admin_content_node('', $name . '[' . $slot . ']', $key);
                }
                echo '</div>';
            }
        } else {
            foreach ($value as $k => $v) {
                admin_content_node($v, $name . '[' . $k . ']', (string) $k);
            }
        }
        echo '</fieldset>';
        return;
    }

    // image upload control
    if ($key === 'image') {
        bs_image_field($name, (string) $value);
        return;
    }

    // scalar
    echo '<div class="mb-3"><label class="lbl">' . e($label) . '</label>';
    if (bs_is_long_key($key) || (is_string($value) && strlen($value) > 70)) {
        echo '<textarea class="ipt" name="' . e($name) . '" rows="3">' . e((string) $value) . '</textarea>';
    } else {
        echo '<input class="ipt" name="' . e($name) . '" value="' . e((string) $value) . '">';
    }
    echo '</div>';
}

/** @param mixed $v */
function bs_is_empty($v): bool
{
    if (is_array($v)) {
        foreach ($v as $x) {
            if (!bs_is_empty($x)) {
                return false;
            }
        }
        return true;
    }
    return trim((string) $v) === '';
}

/**
 * Clean submitted content: reindex list-like arrays, drop empty list items.
 * @param mixed $data @return mixed
 */
function bs_clean_content($data)
{
    if (!is_array($data)) {
        return $data;
    }
    $keys = array_map('strval', array_keys($data));
    $looksList = $keys !== [] && count(array_filter($keys, static fn($k) => preg_match('/^(\d+|new\d+)$/', $k) === 1)) === count($keys);

    if ($looksList) {
        $out = [];
        foreach ($data as $v) {
            $cv = bs_clean_content($v);
            if (!bs_is_empty($cv)) {
                $out[] = $cv;
            }
        }
        return $out;
    }

    $out = [];
    foreach ($data as $k => $v) {
        $out[$k] = bs_clean_content($v);
    }
    return $out;
}
