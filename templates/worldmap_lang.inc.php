<select name="lang" class="parametresFormLangSelect">
    <option class="parametresFormLangOption" value="fr" <?php if ($_POST['lang'] == 'fr') echo 'selected="selected"'; ?>>Français</option>
    <option class="parametresFormLangOption" value="en" <?php if ($_POST['lang'] == 'en') echo 'selected="selected"'; ?>>English</option>
</select>
<input class="parametresFormLangSubmit" type="submit" title="<?php echo MAP_TITLE_LANG_BTN; ?>" value="<?php echo LOGIN_SUBMIT; ?>">
