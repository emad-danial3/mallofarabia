<div class="row">
	<table  class="table ">
    <thead>
        <tr>
            <th>Shift cashier</th>
            <th>Total Cash</th>
            <th>Total Cash returned</th>
            <th>count Visa Recipts </th>
            <th>count Visa Recipts returned </th>
            <th>Total Visa amount </th>
            <th>Total Visa amount returned</th>
        </tr>
    </thead>
    <tbody>
         <?php
        $total_cash =  $total_visa_recipets = $total_visa_cash =  0 ;
        $return_total_cash =  $return_total_visa_recipets = $return_total_visa_cash = $total_cash_all = $total_visa_cash = $total_visa_recipets_all = $return_visa_recipets = $total_visa_cash_all = $total_order_count_all = $total_quantites_all = 0 ;
           ?>
        <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $stats = $shift->stats() ;

        //orders
        $cash = $stats['orders']['total_cash'] ;
        $visa_recipets = $stats['orders']['total_visa_recipets'] ;
        $visa_cash = $stats['orders']['total_visa_cash'] ;
        //return
        $return_cash =$stats['return']['total_cash'] ;
        $return_visa_recipets = $stats['return']['total_visa_recipets'] ;
        $return_visa_cash = $stats['return']['total_visa_cash'] ;
        $total_order_count_all +=$stats['orders']['total_orders_count']  ;
        $total_quantites_all +=$stats['orders']['total_quantites']  ;


        $total_cash += $cash ;
        $return_total_cash += $return_cash ;


        $total_visa_recipets += $visa_recipets ;
        $return_total_visa_recipets += $return_visa_recipets ;

        $total_visa_cash += $visa_cash  ;
        $return_total_visa_cash += $return_visa_cash  ;
        $total_visa_cash_all += $visa_cash - $return_visa_cash ;



         ?>
        <tr>
            <td><?php echo e($shift->cashier->name); ?></td>
            <td><?php echo e($cash); ?></td>
            <td><?php echo e($return_cash); ?></td>
            <td><?php echo e($visa_recipets); ?></td>
            <td><?php echo e($return_visa_recipets); ?></td>
            <td><?php echo e($visa_cash); ?></td>
            <td><?php echo e($return_visa_cash); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php
        $total_cash_all = $total_cash - $return_total_cash ;
        $total_visa_recipets_all = (int)$total_visa_recipets + (int)$return_total_visa_recipets ;
        $total_visa_cash_all = $total_visa_cash  ;
        if($return_total_visa_cash != 0) $total_visa_cash_all.= ' - '. $return_total_visa_cash ;
         ?>


         <tr>
            <td>TOTAL</td>
            <td><?php echo e($total_cash); ?></td>
            <td><?php echo e($return_total_cash); ?></td>
            <td><?php echo e($total_visa_recipets); ?> </td>
            <td><?php echo e($return_total_visa_recipets); ?> </td>
            <td><?php echo e($total_visa_cash); ?> </td>
            <td><?php echo e($return_total_visa_cash); ?> </td>
        </tr>
    </tbody>

</table>
<table class="table " id="closing_day_table">
        <tr>
            <th>Total Cash</th>
            <td><?php echo e($total_cash_all); ?></td>
        </tr>
        <tr>
            <th>All Visa Recipts </th>
            <td><?php echo e($total_visa_recipets_all); ?></td>
        </tr>
        <tr>
            <th>Total Visa amount </th>
            <td><?php echo e($total_visa_cash_all); ?></td>
        </tr>
         <tr>
            <th>Orders Count</th>
            <td><?php echo e($total_order_count_all); ?></td>
        </tr>
        <tr>
            <th>Quantities Count</th>
            <td><?php echo e($total_quantites_all); ?></td>
        </tr>
</table>
<button id="end_day" class="btn btn-success">Print Totals and End Day</button>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      $("#end_day").click(function(){

        $.ajax({
          type: "GET",
          url: "<?php echo e(route('send_day_orders')); ?>",
          data: { },
          success: function(response){
           if(response.status)
           {
             printTable('closing_day_table') ;

           }
          },
          error: function(xhr, status, error){
            console.error("Error:", error);
          }
        });
      });

       function printTable(id) {
        var printWindow = window.open('', '');
        var tableHtml = $("#"+ id).html();
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write(
            '<p>Day: <?php echo e($today .' '.$time_now); ?></p>'+
            '<h4>Name: <?php echo e(session('current_user_name')); ?></h4>'+
            '<table border="1">' + tableHtml + '</table>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
      }
    });
</script>
<?php /**PATH C:\Users\bishoy.sobhy\Desktop\laravel\mall\mallofarabia\resources\views/AdminPanel/PagesContent/store/closing_day_data.blade.php ENDPATH**/ ?>