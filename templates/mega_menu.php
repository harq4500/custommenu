<ul class="sub-menu">
    <div class="cm-container">
        <?php foreach($product_cats as $product_cat): ?>
            <div class="cm-block">
                <h3><a href="<?= $product_cat->url ?>"><?= $product_cat->name ?></a></h3>
                <?php if(count($product_cat->children) > 0): ?>
                    <?php foreach($product_cat->children as $child): ?>
                       <p><a href="<?=$child->url?>"><?=$child->name?></a></p>
                    <?php  endforeach; ?>
                <?php endif; ?>
            </div>
        <?php  endforeach; ?>
    </div>
</ul>