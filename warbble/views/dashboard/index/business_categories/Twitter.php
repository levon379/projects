<?php foreach($business_categories['twitter'] as $label_category => $category): ?>
    <optgroup label="<?php echo $label_category ?>">
        <?php foreach($category as $sub_category): ?>
            <option value="<?php echo $sub_category ?>"><?php echo $sub_category ?></option>
        <?php endforeach ?>
    </optgroup>
<?php endforeach; ?>