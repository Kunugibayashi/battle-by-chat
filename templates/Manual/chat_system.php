<?php
?>
<div class="row">
    <aside class="column">
        <?php echo $this->element('manual_side_nav_item'); ?>
    </aside>
    <div class="column-responsive column-75">
        <div class="content">
            <h3 id="sanka">チャット参加</h3>
            <div class="content-description">
                <p>
                    キャラクター登録をしていない場合、チャットには参加できません。<br>
                    ヘッダー右上にある「設定」→「登録キャラクター編集」→「キャラクター登録」から、キャラクターを登録してください。<br>
                </p>
                <dl>
                    <dt>●入室</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/chat_01.png',
                            [
                                'height' => 50, 'width' => 300,
                                'url' => '/img/manual/chat_01.png',
                            ]
                        ); ?>
                        <p>
                            キャラクターを選択し、「入室」ボタンを押下することで、通常のチャット画面に遷移します。<br>
                        </p>
                    </dd>
                    <dt>●発言・備考欄</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/chat_02.png',
                            [
                                'height' => 160, 'width' => 300,
                                'url' => '/img/manual/chat_02.png',
                            ]
                        ); ?>
                        <p>
                            発言欄、備考欄に入力し、「発言」ボタン押下、または、Ctrl+Enterで発言が可能です。<br>
                            備考欄は任意です。服装や外見特徴、お知らせ事項などを記載可能です。発言後、名前にカーソルを当てることでポップアップされます。<br>
                        </p>
                        <p>
                            発言はタグで装飾が可能です。<br>
                            詳細は「<?= $this->Html->link(__('使用可能タグ一覧'), [
                                'controller' => 'Chat', 'action' => 'htmlTagList']) ?>」を確認してください。<br>
                        </p>
                    </dd>
                    <dt>●退出</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/chat_03.png',
                            [
                                'height' => 160, 'width' => 300,
                                'url' => '/img/manual/chat_03.png',
                            ]
                        ); ?>
                        <p>
                            「退出」ボタンを押下することで、チャットルームから退出します。<br>
                            チャットが終了した場合は、必ず退出してください。<br>
                        </p>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="content">
            <h3 id="betsu">別ウィンドウにログを表示</h3>
            <div class="content-description">
                <p>
                    入室後に別ウィンドウにログを出力するボタンが表示されるようになります。<br>
                    選択すると別ウィンドウでログが開き、メインウィンドウと連携して更新されます。<br>
                    フレームの代わりとしてお使いください。<br>
                    ブラウザによっては、ポップアップを許可しないと動作しない可能性があります。<br>
                </p>
                <dl>
                    <dt>●別ウィンドウにログを表示</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/chat_04.png',
                            [
                                'height' => 200, 'width' => 300,
                                'url' => '/img/manual/chat_04.png',
                            ]
                        ); ?>
                        <p>
                            「別ウィンドウでログを表示する」で別ウィンドウにログを表示します。<br>
                        </p>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="content">
            <h3 id="daisu">ダイス</h3>
            <div class="content-description">
                <p>
                    TRPGツールのように本格的なものではありませんが、チャット中でもダイスをふることができます。<br>
                    ダイス欄に入力して「ダイス」を押下してください。<br>
                </p>
                <dl>
                    <dt>●ダイス</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/chat_05.png',
                            [
                                'height' => 200, 'width' => 300,
                                'url' => '/img/manual/chat_05.png',
                            ]
                        ); ?>
                        <p>
                            例）<br>
                            1d100：100面ダイス1個<br>
                            2d6：6面ダイス2個<br>
                            10d100：100面ダイス10個（最大）<br>
                        </p>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="content">
            <h3 id="settei">自由設定ルーム変更</h3>
            <div class="content-description">
                <p>
                    自由設定ルームは、「ルーム名」と「ルーム説明」を変更することができます。<br>
                </p>
                <dl>
                    <dt>●自由設定画面表示</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/chat_06.png',
                            [
                                'height' => 100, 'width' => 300,
                                'url' => '/img/manual/chat_06.png',
                            ]
                        ); ?>
                        <p>
                            「部屋設定変更」を押下すると、部屋設定変更画面が表示されます。<br>
                        </p>
                    </dd>
                    <dt>●部屋設定</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/chat_07.png',
                            [
                                'height' => 100, 'width' => 300,
                                'url' => '/img/manual/chat_07.png',
                            ]
                        ); ?>
                        <p>
                            各設定変更して「変更」を押下してください。<br>
                            既に入室者がいる場合は変更できません。<br>
                        </p>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="content">
            <h3 id="log">ログ保存</h3>
            <div class="content-description">
                <p>
                    チャット参加後、ログ倉庫にログが出力され、保存が可能です。<br>
                    ログが出力されるタイミングは、チャットルーム内の参加者が全員退出した後となります。<br>
                    背景色や背景画像は当時の状態の保存が難しいため、ログ倉庫には出力されません。<br>
                </p>
                <dl>
                    <dt>●ログ倉庫</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/log_dl_01.png',
                            [
                                'height' => 80, 'width' => 300,
                                'url' => '/img/manual/log_dl_01.png',
                            ]
                        ); ?>
                        <p>
                            「ログ倉庫」の「≫ More」を押下して、ログ一覧を表示してください。<br>
                        </p>
                    </dd>
                    <dt>●ログ一覧</dt>
                    <dd>
                        <?php echo $this->Html->image('manual/log_dl_02.png',
                            [
                                'height' => 120, 'width' => 300,
                                'url' => '/img/manual/log_dl_02.png',
                            ]
                        ); ?>
                        <p>
                            対象ログの「DL」を右クリックし、「リンク先を別名で保存」でログを保存することが可能です。<br>
                            もしくは、「DL」を押下し、WEBページを表示した後、右クリックから「別名で保存」を選択してください。<br>
                        </p>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
