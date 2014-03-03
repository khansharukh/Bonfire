<?php defined('BASEPATH') || exit('No direct script access allowed');

$pager = '';
if ($this->input->post('use_pagination') == 'true') {
    $pager = "
    echo \$this->pagination->create_links();";
}

$headers = '';
for ($counter=1; $field_total >= $counter; $counter++) {
	// Only build on fields that have data entered.
	if (set_value("view_field_label$counter") == null) {
		continue; 	// move onto next iteration of the loop
	}

	$headers .= '
		<th>'. set_value("view_field_label$counter").'</th>';
}

if ($use_soft_deletes == 'true') {
	$headers .= '
		<th>
			<?php echo lang("'.$module_name_lower.'_column_deleted"); ?>
		</th>';
}
if ($use_created == 'true') {
	$headers .= '
		<th>
			<?php echo lang("'.$module_name_lower.'_column_created"); ?>
		</th>';
}
if ($use_modified == 'true') {
	$headers .= '
		<th>
			<?php echo lang("'.$module_name_lower.'_column_modified"); ?>
		</th>';
}

echo "<div>
	<h1 class='page-header'>
		<?php echo lang('{$module_name_lower}_area_title'); ?>
	</h1>
</div>
<?php if (isset(\$records) && is_array(\$records) && count(\$records)) : ?>
<table class='table table-striped table-bordered'>
    <thead>
        <tr>
            {$headers}
        </tr>
    </thead>
    <tbody>
        <?php
        foreach (\$records as \$record) :
            \$record = (array)\$record;
        ?>
        <tr>
            <?php
            foreach(\$record as \$field => \$value) :
                if (\$field != '{$primary_key_field}') :
            ?>
            <td>
                <?php
                if (\$field == 'deleted') {
                    e((\$value > 0) ? lang('{$module_name_lower}_true') : lang('{$module_name_lower}_false'));
                } else {
                    e(\$value);
                }
                ?>
            </td>
            <?php
                endif;
            endforeach;
            ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
{$pager}
endif; ?>";