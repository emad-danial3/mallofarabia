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
        @foreach($shifts as $shift)
        <?php $stats = $shift->stats() ;
        $total_cash += $stats['total_cash'] ;
        $total_visa_recipets += $stats['total_visa_recipets'] ;
        $total_visa_cash += $stats['total_visa_cash'] ;
         ?>
        <tr>
            <td>{{$shift->cashier->name}}</td>
            <td>{{$stats['total_cash']}}</td>
            <td>{{$stats['total_visa_recipets'] }} </td>
            <td>{{$stats['total_visa_cash']}} </td>
        </tr>
        @endforeach
         <tr>
            <td>TOTAL</td>
            <td>{{ $total_cash  }}</td>
            <td>{{ $total_visa_recipets }} </td>
            <td>{{ $total_visa_cash }} </td>
        </tr>
    </tbody>
    
</table>
<button class="btn btn-success"> End Day</button>
</div>