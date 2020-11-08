<style>
</style>
<div id="id-color-preview-modal">
    <?php
    echo $this->Form->control('color', [
        'label' => 'キャラクター色',
        'v-model' => 'activeColor',
    ]);
    echo $this->Form->button(__('色選択'), [
        'type' => 'button',
        'v-on:click' => 'showModal = true, cSelect = true, bSelect = false',
    ]);
    echo $this->Form->control('backgroundcolor', [
        'label' => 'キャラクター背景色',
        'v-model' => 'backgroundActiveColor',
    ]);
    echo $this->Form->button(__('色選択'), [
        'type' => 'button',
        'v-on:click' => 'showModal = true, bSelect = true, cSelect = false',
    ]);
    ?>
    <?php
    // プレビューのみなので間にスペース許容
    echo $this->Form->control('ColorPreview', [
            'label' => '選択色プレビュー',
            'v-bind:style' => '{ color: activeColor, backgroundColor: backgroundActiveColor }',
            'value' => __('選択した色はこのように表示されます。'),
            'disabled' => true,
        ]
    );
    ?>
    <modal v-if="showModal" @close="showModal = false">
        <h3 slot="header"><?php echo __('Select Color'); ?></h3>
        <div slot="body">
            <ul v-if="cSelect">
              <li v-for="color in colors"
                  v-bind:style="{ color: color.code }"
                  @click="showModal = false, cSelect = false, activeColor = color.code">
                  ■{{ color.name }}</li>
            </ul>
            <ul v-if="bSelect">
              <li v-for="color in colors"
                  v-bind:style="{ color: color.code }"
                  @click="showModal = false, bSelect = false, backgroundActiveColor = color.code">
                  ●{{ color.name }}</li>
            </ul>
        </div>
    </modal>
</div>
<script>
var color_preview_modal = new Vue({
    el: "#id-color-preview-modal",
    data: {
        activeColor: "<?php echo h($chatCharacter->color); ?>",
        backgroundActiveColor: "<?php echo h($chatCharacter->backgroundcolor); ?>",
        showModal: false,
        colors: [
            <?php foreach ($colorCodes as $value) { ?>
                { 'code': '<?= $value['code'] ?>', 'name': '<?= $value['name'] ?>', },
            <?php } ?>
        ],
        cSelect: false,
        bSelect: false,
    },
    computed: {
        activeColor: function () { return this.activeColor },
        backgroundActiveColor: function () { return this.backgroundActiveColor },
    }
});
</script>
