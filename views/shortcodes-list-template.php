<?php

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$cs_list = get_option('cs_list');
if ( ! empty($cs_list)) {
    $counter = 1; ?>
    <div class="cs-list">
        <table>
            <thead>
            <tr>
                <th>#</th>
                <th>Display name</th>
                <th>Shortcode</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($cs_list as $key => $cs_item) {
                $data_option = $cs_item;
                unset($data_option['shortcode']); ?>
                <tr data-options='<?= json_encode($data_option); ?>'>
                    <td><?= $counter; ?></td>
                    <td class="cs-name"><?= isset($cs_item['name']) ? $cs_item['name'] : ''; ?></td>
                    <td class="cs-code"><?= $cs_item['shortcode']; ?></td>
                    <td>
                        <span class="remove-item" data-id="<?= $key; ?>"></span>
                        <span class="dashicons-edit edit-item" data-id="<?= $key; ?>"></span>
                    </td>
                </tr>
                <?php $counter++;
            } ?>
            </tbody>
        </table>
    </div>
    <?php
}
