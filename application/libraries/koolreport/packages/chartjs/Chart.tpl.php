<div class="chartjs-container" style="<?php echo $this->width?"width:$this->width;":""; ?><?php echo $this->height?"height:$this->height;":""; ?>">
    <canvas id="<?php echo $this->name; ?>"></canvas>
</div>
<script type="text/javascript">
var <?php echo $this->name; ?> = new ChartJS("<?php echo $this->name; ?>",<?php echo json_encode($settings); ?>);
<?php
foreach($this->clientEvents as $name=>$function)
{
?>
<?php echo $this->name; ?>.on('<?php echo $name; ?>',<?php echo $function; ?>);
<?php    
}
?>
</script>