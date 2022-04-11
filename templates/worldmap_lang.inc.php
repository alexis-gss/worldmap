<select name="lang" class="parametresFormLangSelect" onchange='if(this.value != 0) { this.form.submit(); }'>
    <option class="parametresFormLangOption" value="fr" <?php if ($_POST['lang'] == 'fr') echo 'selected="selected"'; ?>>Français</option>
    <option class="parametresFormLangOption" value="en" <?php if ($_POST['lang'] == 'en') echo 'selected="selected"'; ?>>English</option>
</select>