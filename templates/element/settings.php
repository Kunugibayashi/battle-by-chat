<div id="id-settings-modal">
  <button id="show-modal" @click="showModal = true" class="top-nav-links-settings-button">
      <?php echo $this->Html->image('site-setting.png'); ?>
      <?php echo __('設定'); ?>
  </button>
  <modal v-if="showModal" @close="showModal = false">
      <h3 slot="header"><?php echo __('設定'); ?></h3>
      <div slot="body">
        <ul>
            <li><?= $this->Html->link(__('ログアウト'), ['controller' => 'Users', 'action' => 'logout',]) ?></li>
        </ul>
        <ul>
            <li><?= $this->Html->link(__('パスワード変更'), ['controller' => 'Users', 'action' => 'edit',]) ?></li>
            <li><?= $this->Html->link(__('登録キャラクター編集'), ['controller' => 'ChatCharacters', 'action' => 'index',]) ?></li>
            <li><?= $this->Html->link(__('発言編集'), ['controller' => 'ChatMessageEdit', 'action' => 'index',]) ?></li>
        </ul>
        <ul>
            <li><?= $this->Html->link(__('お知らせ'), ['controller' => 'Informations', 'action' => 'index',]) ?></li>
            <li><?= $this->Html->link(__('私書'), ['controller' => 'Messages', 'action' => 'index',]) ?></li>
            <li><?= $this->Html->link(__('名簿'), ['controller' => 'ChatCharacters', 'action' => 'search',]) ?></li>
            <li><?= $this->Html->link(__('部屋'), ['controller' => 'Chat', 'action' => 'index', 1]) ?></li>
            <li><?= $this->Html->link(__('ログ倉庫'), ['controller' => 'ChatLogWarehouses', 'action' => 'index',]) ?></li>
            <li><?= $this->Html->link(__('Topへ戻る'), []) ?></li>
        </ul>
      </div>
  </modal>
</div>
<script>
var settings_modal = new Vue({
    el: "#id-settings-modal",
    data: {
        showModal: false
    }
});
</script>
