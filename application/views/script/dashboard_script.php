<script>
    $('#session_store').change(function(){
        window.location.href = '<?php echo base_url('dashboard/switch_store') ?>/'+$(this).val();
    })
</script>