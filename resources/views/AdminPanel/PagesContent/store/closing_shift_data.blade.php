<div class="row">
	<table  class="table ">
    <thead>
        <tr>
            <th>Total Cash</th>
            <th>Total Retrun Cash</th>
            <th>count Visa Recipts </th>
            <th>count return Visa Recipts </th>
            <th>Total Visa amount</th>
            <th>Total return Visa amount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{$orders['total_cash']}}</td>
            <td>{{$return['total_cash']}}</td>
            <td>{{$orders['total_visa_recipets'] }} </td>
            <td>{{$return['total_visa_recipets'] }} </td>
            <td>{{$orders['total_visa_cash']}} </td>
            <td>{{$return['total_visa_cash']}} </td>
        </tr>
       
    </tbody>
    
</table>

<table id="closing_shift_table" class="table ">
        <tr>
            <th>All Total Cash</th>
            <td> {{ $orders['total_cash'] - $return['total_cash'] }} </td>
        </tr>
        <tr>
            <th>All Total Visa Recipts</th>
            <td>{{ $orders['total_visa_recipets'] + $return['total_visa_recipets'] }} </td>
        </tr>
         <tr>
            <th>All Total Visa Amount</th>
            <td>{{ $orders['total_visa_cash'] }}
            {{ $return['total_visa_cash'] != 0 ? ' - ' . $return['total_visa_cash'] : ''}}  </td>
        </tr>
</table>
</div>
<button id="end_shift" class="btn btn-success">Print Totals</button>
<script type="text/javascript">
    $(document).ready(function(){
   $("#end_shift").click(function(){
    printTable('closing_shift_table')
   });

       function printTable(id) {
        var printWindow = window.open('', '_blank');
        var tableHtml = $("#"+ id).html();
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write('<h2>shift id: {{$current_shift_id}} Cashier :{{ $shift->cashier->name }}</h2><table border="1">' + tableHtml + '</table>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
      }
    });
</script>