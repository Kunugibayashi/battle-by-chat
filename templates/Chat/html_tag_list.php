<style>
.bold { font-weight: bold; }
.oblique { font-style: oblique; }
.line-through { text-decoration: line-through; }
.font50 { font-size: 50%; } .font150 { font-size: 150%; } .font200 { font-size: 200%; }
<?php foreach ($colorCodes as $value) { ?><?php echo "." .$value['name'] ?> { color: <?= $value['code'] ?>; } <?php } ?>

</style>
<div class="row">
    <div class="column-responsive column">
        <div class="content">
            <h3>HTMLタグについて</h3>
            <div class="content-description">
                <p>
                    HTMLタグは、発言のみに使用可能です。<br>
                    「使用可能タグ一覧」に記載されたタグ以外は使用できません。<br>
                    複数のclass装飾を使用したい場合は、半角スペースを挟み、並べて記載してください。<br>
                </p>
                <p>
                    例）<br>
                    書き方：<?php echo h('<span class="bold oblique blue">複数class名での装飾例です。</span>'); ?><br>
                    見え方：<span class="bold blue oblique">複数class名での装飾例です。</span><br>
                </p>
            </div>
        </div>
        <div class="content">
            <h3>使用可能タグ一覧</h3>
            <table>
                <thead>
                    <tr>
                        <th>タグ名</th>
                        <th>見え方</th>
                        <th>使用例</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>span</td>
                        <td><span>span</span></td>
                        <td><?php echo h('<span class="class名">span</span>'); ?></td>
                    </tr>
                    <tr>
                        <td>ruby, rp, rt</td>
                        <td><ruby>Abitopia<rp>(</rp><rt>あびとぴあ</rt><rp>)</rp></ruby></td>
                        <td><?php echo h('<ruby>Abitopia<rp>(</rp><rt>あびとぴあ</rt><rp>)</rp></ruby>'); ?></td>
                    </tr>
                 </tbody>
             </table>
        </div>
        <div class="content">
            <h3>使用可能class一覧</h3>
            <table>
                <thead>
                    <tr>
                        <th>class名</th>
                        <th>見え方</th>
                        <th>使用例</th>
                    </tr>
                </thead>
               <tbody>
                   <tr>
                       <td>bold</td>
                       <td><span class="bold">サンプル</span></td>
                       <td><?php echo h('<span class="bold">サンプル</span>'); ?></td>
                   </tr>
                   <tr>
                       <td>oblique</td>
                       <td><span class="oblique">サンプル</span></td>
                       <td><?php echo h('<span class="oblique">サンプル</span>'); ?></td>
                   </tr>
                   <tr>
                       <td>line-through</td>
                       <td><span class="line-through">サンプル</span></td>
                       <td><?php echo h('<span class="line-through">サンプル</span>'); ?></td>
                   </tr>
                   <tr>
                       <td>font50</td>
                       <td><span class="font50">サンプル</span></td>
                       <td><?php echo h('<span class="font50">サンプル</span>'); ?></td>
                   </tr>
                   <tr>
                       <td>font150</td>
                       <td><span class="font150">サンプル</span></td>
                       <td><?php echo h('<span class="font150">サンプル</span>'); ?></td>
                   </tr>
                   <tr>
                       <td>font200</td>
                       <td><span class="font200">サンプル</span></td>
                       <td><?php echo h('<span class="font200">サンプル</span>'); ?></td>
                   </tr>
                   <?php foreach ($colorCodes as $value) { ?>
                       <tr>
                           <td><?= $value['name'] ?></td>
                           <td><span class="<?= $value['name'] ?>">サンプル</span></td>
                           <td><?php echo h('<span class="' .$value['name'] .'">サンプル</span>'); ?></td>
                       </tr>
                   <?php } ?>
                </tbody>
             </table>
        </div>
    </div>
</div>
