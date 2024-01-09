<div class="row">
	<table id="closing_day_table" class="table ">
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
<button id="end_day" class="btn btn-success">Print Totals End Day</button>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      $("#end_day").click(function(){

        $.ajax({
          type: "GET",  
          url: "{{route('send_day_orders')}}", 
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
        // Open a new window
        var printWindow = window.open('', '_blank');

        // Get the HTML content of the table
        var tableHtml = $("#"+ id).html();

        // Set the content of the new window with the table HTML
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write('<table border="1">' + tableHtml + '</table>');
        printWindow.document.write('</body></html>');

        // Close the document
        printWindow.document.close();

        // Trigger the print dialog
        printWindow.print();
      }
    });
</script>