<?php
/**
 * This file contains Chart view
 *
 * @author KoolPHP Inc (support@koolphp.net)
 * @link https://www.koolphp.net
 * @copyright KoolPHP Inc
 * @license https://www.koolreport.com/license
 */
?>
<span id="<?php echo $this->id; ?>" class="sparkline"></span>
<script type="text/javascript">
$('#<?php echo $this->id; ?>').sparkline(<?php echo json_encode($this->data) ?>,<?php echo json_encode($this->options); ?>);
</script>