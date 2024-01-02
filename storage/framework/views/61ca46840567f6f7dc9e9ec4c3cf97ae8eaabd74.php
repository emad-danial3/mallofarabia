<div class="row">
	<table class="table ">
    <thead>
        <tr>
            <th>Shift cashier</th>
            <th>Total Cash</th>
            <th>count Visa Recipts </th>
            <th>Total Visa amount</th>
        </tr>
    </thead>
    <tbody>
         <?php 
        $total_cash =  $total_visa_recipets = $total_visa_cash =  0 ;
           ?>
        <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $stats = $shift->stats() ;
        $total_cash += $stats['total_cash'] ;
        $total_visa_recipets += $stats['total_visa_recipets'] ;
        $total_visa_cash += $stats['total_visa_cash'] ;
         ?>
        <tr>
            <td><?php echo e($shift->cashier->name); ?></td>
            <td><?php echo e($stats['total_cash']); ?></td>
            <td><?php echo e($stats['total_visa_recipets']); ?> </td>
            <td><?php echo e($stats['total_visa_cash']); ?> </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <tr>
            <td>TOTAL</td>
            <td><?php echo e($total_cash); ?></td>
            <td><?php echo e($total_visa_recipets); ?> </td>
            <td><?php echo e($total_visa_cash); ?> </td>
        </tr>
    </tbody>
    
</table>
</div><?php /**PATH C:\Users\bishoy.sobhy\Desktop\laravel\mall\mallofarabia\resources\views/AdminPanel/PagesContent/store/closing_day_data.blade.php ENDPATH**/ ?>