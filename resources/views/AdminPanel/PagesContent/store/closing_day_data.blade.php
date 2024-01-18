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
        @foreach($shifts as $shift)
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
            <td>{{$shift->cashier->name}}</td>
            <td>{{$cash}}</td>
            <td>{{$return_cash}}</td>
            <td>{{$visa_recipets}}</td>
            <td>{{$return_visa_recipets}}</td>
            <td>{{$visa_cash}}</td>
            <td>{{$return_visa_cash}}</td>
        </tr>
        @endforeach
        <?php
        $total_cash_all = $total_cash - $return_total_cash ;
        $total_visa_recipets_all = (int)$total_visa_recipets + (int)$return_total_visa_recipets ;
        $total_visa_cash_all = $total_visa_cash  ;
        if($return_total_visa_cash != 0) $total_visa_cash_all.= ' - '. $return_total_visa_cash ;
         ?>


         <tr>
            <td>TOTAL</td>
            <td>{{ $total_cash  }}</td>
            <td>{{ $return_total_cash  }}</td>
            <td>{{ $total_visa_recipets }} </td>
            <td>{{ $return_total_visa_recipets }} </td>
            <td>{{ $total_visa_cash }} </td>
            <td>{{ $return_total_visa_cash }} </td>
        </tr>
    </tbody>

</table>
<table class="table " id="closing_day_table">
        <tr>
            <th>Total Cash</th>
            <td>{{$total_cash_all}}</td>
        </tr>
        <tr>
            <th>All Visa Recipts </th>
            <td>{{$total_visa_recipets_all}}</td>
        </tr>
        <tr>
            <th>Total Visa amount </th>
            <td>{{$total_visa_cash_all}}</td>
        </tr>
         <tr>
            <th>Orders Count</th>
            <td>{{$total_order_count_all}}</td>
        </tr>
        <tr>
            <th>Quantities Count</th>
            <td>{{$total_quantites_all}}</td>
        </tr>
</table>
<button id="end_day" class="btn btn-success">Print Totals and End Day</button>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      $("#end_day").click(function(){
        $(this).prop('disabled', true);
         $(this).html('<i class="fa fa-spinner fa-spin fa-3x"></i>');
        $.ajax({
          type: "GET",
          url: "{{route('send_day_orders')}}",
          data: { },
          success: function(response){
           if(response.status)
           {
            $("#end_day").prop('disabled', false);
            $("#end_day").html('Print Totals and End Day');
            printTable('closing_day_table') ;
           }
           
          },
          error: function(xhr, status, error){
            $("#end_day").prop('disabled', false);
            $("#end_day").html('Print Totals and End Day');
            console.error("Error:", error);
          }
           
        });
      });

       function printTable(id) {
        var printWindow = window.open('', '');
        var tableHtml = $("#"+ id).html();
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write(
            '<p>Day: {{$today .' '.$time_now}}</p>'+
            '<h4>Name: {{session('current_user_name')}}</h4>'+
            '<table border="1">' + tableHtml + '</table>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
      }
    });
</script>
