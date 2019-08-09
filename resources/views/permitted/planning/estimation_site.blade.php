<div id="" class="">
  <h4 class="text-primary text-center">{{$data[0]->sitio}}</h4>
  <table id="estimation_table" class="table table-bordered table-condensed">
    <thead>
      <tr style="background: #193257">
        <th rowspan="2" class="text-white" style="vertical-align:middle;max-width:100px">Programado vs Ejercido</th>
        <th class="text-white text-center" colspan="5">COSTO VARIABLE</th>
        <th class="text-white text-center" colspan="2">COSTO FIJO</th>
        <th class="text-white text-center" colspan="2" rowspan="2" style="vertical-align:middle;min-width:110px;">Total</th>
      </tr>
      <tr class="text-white" style="background:#B8B6AA;">
        <th>Equipo Activo</th>
        <th>Equipo No Activo</th>
        <th>Mano de obra</th>
        <th>Licencias</th>
        <th>Viáticos</th>
        <th>Enlaces</th>
        <th>Costo ITC</th>
      </tr>
    </thead>
    <tbody>
      <tr class="text-center">
        <td style="background: #193257;font-weight:bold;" class="text-white text-left">DOCUMENTO P</td>
        @php
           $docp_percent_1 = 0;
          ($data[0]->total_usd != 0) ? $docp_percent_1 = ($data[7]->total_usd / $data[0]->total_usd) * 100 : $docp_percent_1 = 0;
           //
           $docp_percent_2 = 0;
          ($data[1]->total_usd != 0) ? $docp_percent_2 = ($data[8]->total_usd / $data[1]->total_usd) * 100 : $docp_percent_2 = 0;
          //
           $docp_percent_3 = 0;
          ($data[2]->total_usd != 0) ? $docp_percent_3 = ($data[9]->total_usd / $data[2]->total_usd) * 100 : $docp_percent_3 = 0;
          //
           $docp_percent_4 = 0;
          ($data[3]->total_usd != 0) ? $docp_percent_4 = ($data[10]->total_usd / $data[3]->total_usd) * 100 : $docp_percent_4 = 0;
          //
           $docp_percent_5 = 0;
          ($data[4]->total_usd != 0) ? $docp_percent_4 = ($data[11]->total_usd / $data[4]->total_usd) * 100 : $docp_percent_4 = 0;
          //
           $docp_percent_6 = 0;
          ($data[5]->total_usd != 0) ? $docp_percent_4 = ($data[12]->total_usd / $data[5]->total_usd) * 100 : $docp_percent_4 = 0;
          //
           $docp_percent_7 = 0;
          ($data[6]->total_usd != 0) ? $docp_percent_4 = ($data[13]->total_usd / $data[6]->total_usd) * 100 : $docp_percent_4 = 0;
        @endphp
        <td class="text-bold">{{ number_format( $docp_percent_1, 2, '.', '') }} %</td> <!-- Equipo Activo %-->
        <td class="text-bold">{{ number_format( $docp_percent_2, 2, '.', '') }} %</td> <!-- Equipo No Activo -->
        <td class="text-bold">{{ number_format( $docp_percent_3, 2, '.', '') }} %</td> <!-- Mano de obra -->
        <td class="text-bold">{{ number_format( $docp_percent_4, 2, '.', '') }} %</td> <!-- Licencias (USD) -->
        <td class="text-bold">{{ number_format( $docp_percent_5, 2, '.', '') }}%</td> <!-- Viáticos -->
        <td class="text-bold">{{ number_format( $docp_percent_6, 2, '.', '') }} %  </td> <!-- Enlaces -->
        <td class="text-bold">{{ number_format( $docp_percent_7, 2, '.', '') }} %  </td> <!-- Costo ITC -->
        <td style="font-weight:bold">
        @php
          $percent_docp =  ($docp_percent_1 + $docp_percent_2 + $docp_percent_3 + $docp_percent_4 +  $docp_percent_5 + $docp_percent_6 +$docp_percent_7) / 7;
        @endphp
          {{ number_format($percent_docp, 2, '.', ',') }}%
        </td>
      </tr>
       <tr class="text-center">
         <td style="background: #193257;font-weight:bold;" class="text-white text-right">Programado</td>
         <td>$ {{ number_format($data[0]->total_usd, 2, '.', ',') }}</td> <!-- Equipo Activo -->
         <td>$ {{ number_format($data[1]->total_usd, 2, '.', ',') }}</td> <!-- Equipo No Activo -->
         <td>$ {{ number_format($data[2]->total_usd, 2, '.', ',') }}</td> <!-- Mano de obra -->
         <td>$ {{ number_format($data[3]->total_usd, 2, '.', ',') }}</td> <!-- Licencias (USD) -->
         <td>$ {{ number_format($data[4]->total_usd, 2, '.', ',') }}</td> <!-- Viáticos -->
         <td>$ {{ number_format($data[5]->total_usd, 2, '.', ',') }}  </td> <!-- Enlaces -->
         <td>$ {{ number_format($data[6]->total_usd, 2, '.', ',') }}  </td> <!-- Costo ITC -->
         <td style="font-weight:bold">
           @php
             $total_programado_docp =  $data[0]->total_usd + $data[1]->total_usd + $data[2]->total_usd + $data[3]->total_usd + $data[4]->total_usd + $data[5]->total_usd + $data[6]->total_usd;
           @endphp
           $ {{ number_format($total_programado_docp, 2, '.', ',') }}
         </td>
      </tr>
      <tr class="text-center">
        <td style="background: #193257;font-weight:bold;" class="text-white text-right">Ejercido</td>
        <td>$ {{ number_format($data[7]->total_usd, 2, '.', ',') }}</td> <!-- Equipo Activo -->
        <td>$ {{ number_format($data[8]->total_usd, 2, '.', ',') }}</td> <!-- Equipo No Activo -->
        <td>$ {{ number_format($data[9]->total_usd, 2, '.', ',') }}</td> <!-- Mano de obra -->
        <td>$ {{ number_format($data[10]->total_usd, 2, '.', ',') }}</td> <!-- Licencias (USD) -->
        <td>$ {{ number_format($data[11]->total_usd, 2, '.', ',') }}</td> <!-- Viáticos -->
        <td>$ {{ number_format($data[12]->total_usd, 2, '.', ',') }}  </td> <!-- Enlaces -->
        <td>$ {{ number_format($data[13]->total_usd, 2, '.', ',') }}  </td> <!-- Costo ITC -->
        <td style="font-weight:bold">
          @php
            $total_ejercido_docp =  $data[7]->total_usd + $data[8]->total_usd + $data[9]->total_usd + $data[10]->total_usd + $data[11]->total_usd + $data[12]->total_usd + $data[13]->total_usd;
          @endphp
          $ {{ number_format($total_ejercido_docp, 2, '.', ',') }}
        </td>
      </tr>
      <tr class="text-center">
        <td style="background: #193257;font-weight:bold;" class="text-white text-left">DOCUMENTO M</td>
        @php
           $docm_percent_1 = 0;
          ($data[14]->total_usd != 0) ? $docm_percent_1 = ($data[21]->total_usd / $data[14]->total_usd) * 100 : $docm_percent_1 = 0;
           //
           $docm_percent_2 = 0;
          ($data[15]->total_usd != 0) ? $docm_percent_2 = ($data[22]->total_usd / $data[15]->total_usd) * 100 : $docm_percent_2 = 0;
          //
           $docm_percent_3 = 0;
          ($data[16]->total_usd != 0) ? $docm_percent_3 = ($data[23]->total_usd / $data[16]->total_usd) * 100 : $docm_percent_3 = 0;
          //
           $docm_percent_4 = 0;
          ($data[17]->total_usd != 0) ? $docm_percent_4 = ($data[24]->total_usd / $data[17]->total_usd) * 100 : $docm_percent_4 = 0;
          //
           $docm_percent_5 = 0;
          ($data[18]->total_usd != 0) ? $docm_percent_5 = ($data[25]->total_usd / $data[18]->total_usd) * 100 : $docm_percent_5 = 0;
          //
           $docm_percent_6 = 0;
          ($data[19]->total_usd != 0) ? $docm_percent_6 = ($data[26]->total_usd / $data[19]->total_usd) * 100 : $docm_percent_6 = 0;
          //
           $docm_percent_7 = 0;
          ($data[20]->total_usd != 0) ? $docm_percent_7 = ($data[27]->total_usd / $data[20]->total_usd) * 100 : $docm_percent_7 = 0;
        @endphp
        <td class="text-bold">{{ number_format( $docm_percent_1, 2, '.', '') }} %</td> <!-- Equipo Activo %-->
        <td class="text-bold">{{ number_format( $docm_percent_2, 2, '.', '') }} %</td> <!-- Equipo No Activo -->
        <td class="text-bold">{{ number_format( $docm_percent_3, 2, '.', '') }} %</td> <!-- Mano de obra -->
        <td class="text-bold">{{ number_format( $docm_percent_4, 2, '.', '') }} %</td> <!-- Licencias (USD) -->
        <td class="text-bold">{{ number_format( $docm_percent_5, 2, '.', '') }}%</td> <!-- Viáticos -->
        <td class="text-bold">{{ number_format( $docm_percent_6, 2, '.', '') }} %  </td> <!-- Enlaces -->
        <td class="text-bold">{{ number_format( $docm_percent_7, 2, '.', '') }} %  </td> <!-- Costo ITC -->
        <td style="font-weight:bold">
          @php
            $percent_docm =  ($docm_percent_1 + $docm_percent_2 + $docm_percent_3 + $docm_percent_4 +  $docm_percent_5 + $docm_percent_6 +$docm_percent_7) / 7;
          @endphp
            {{ number_format($percent_docm, 2, '.', ',') }}%
        </td>
      </tr>
       <tr class="text-center">
         <td style="background: #193257;font-weight:bold;" class="text-white text-right">Programado</td>
         <td>$ {{ number_format($data[14]->total_usd, 2, '.', ',') }}</td> <!-- Equipo Activo -->
         <td>$ {{ number_format($data[15]->total_usd, 2, '.', ',') }}</td> <!-- Equipo No Activo -->
         <td>$ {{ number_format($data[16]->total_usd, 2, '.', ',') }}</td> <!-- Mano de obra -->
         <td>$ {{ number_format($data[17]->total_usd, 2, '.', ',') }}</td> <!-- Licencias (USD) -->
         <td>$ {{ number_format($data[18]->total_usd, 2, '.', ',') }}</td> <!-- Viáticos -->
         <td>$ {{ number_format($data[19]->total_usd, 2, '.', ',') }}  </td> <!-- Enlaces -->
         <td>$ {{ number_format($data[20]->total_usd, 2, '.', ',') }}  </td> <!-- Costo ITC -->
         <td style="font-weight:bold">
           @php
             $total_programado_docm =  $data[14]->total_usd + $data[15]->total_usd + $data[16]->total_usd + $data[17]->total_usd + $data[18]->total_usd + $data[19]->total_usd + $data[20]->total_usd;
           @endphp
           $ {{ number_format($total_programado_docm, 2, '.', ',') }}
         </td>
      </tr>
      <tr class="text-center">
        <td style="background: #193257;font-weight:bold;" class="text-white text-right">Ejercido</td>
        <td>$ {{ number_format($data[21]->total_usd, 2, '.', ',') }}</td> <!-- Equipo Activo -->
        <td>$ {{ number_format($data[22]->total_usd, 2, '.', ',') }}</td> <!-- Equipo No Activo -->
        <td>$ {{ number_format($data[23]->total_usd, 2, '.', ',') }}</td> <!-- Mano de obra -->
        <td>$ {{ number_format($data[24]->total_usd, 2, '.', ',') }}</td> <!-- Licencias (USD) -->
        <td>$ {{ number_format($data[25]->total_usd, 2, '.', ',') }}</td> <!-- Viáticos -->
        <td>$ {{ number_format($data[26]->total_usd, 2, '.', ',') }}  </td> <!-- Enlaces -->
        <td>$ {{ number_format($data[27]->total_usd, 2, '.', ',') }}  </td> <!-- Costo ITC -->
        <td style="font-weight:bold">
          @php
            $total_ejercido_docm =  $data[21]->total_usd + $data[22]->total_usd + $data[23]->total_usd + $data[24]->total_usd + $data[25]->total_usd + $data[26]->total_usd + $data[27]->total_usd;
          @endphp
          $ {{ number_format($total_ejercido_docm, 2, '.', ',') }}
        </td>
      </tr>
      <!---Total pagado-->
      <tr class="text-center">
        <td style="background: #193257;font-weight:bold;" class="text-white text-right">Total pagado</td>
        <td class="text-bold">$ {{ number_format($data[7]->total_usd + $data[21]->total_usd, 2, '.', ',') }}</td> <!-- Equipo Activo -->
        <td class="text-bold">$ {{ number_format($data[8]->total_usd + $data[22]->total_usd, 2, '.', ',') }}</td> <!-- Equipo No Activo -->
        <td class="text-bold">$ {{ number_format($data[9]->total_usd + $data[23]->total_usd, 2, '.', ',') }}</td> <!-- Mano de obra -->
        <td class="text-bold">$ {{ number_format($data[10]->total_usd + $data[24]->total_usd, 2, '.', ',') }}</td> <!-- Licencias (USD) -->
        <td class="text-bold">$ {{ number_format($data[11]->total_usd + $data[25]->total_usd, 2, '.', ',') }}</td> <!-- Viáticos -->
        <td class="text-bold">$ {{ number_format($data[12]->total_usd + $data[26]->total_usd, 2, '.', ',') }}  </td> <!-- Enlaces -->
        <td class="text-bold">$ {{ number_format($data[13]->total_usd + $data[27]->total_usd, 2, '.', ',') }}  </td> <!-- Costo ITC -->
        <td style="font-weight:bold">

          $ {{ number_format($data[7]->total_usd + $data[21]->total_usd + $data[8]->total_usd + $data[22]->total_usd + $data[9]->total_usd + $data[23]->total_usd + $data[10]->total_usd + $data[24]->total_usd + $data[11]->total_usd + $data[25]->total_usd + $data[12]->total_usd + $data[26]->total_usd + $data[13]->total_usd + $data[27]->total_usd, 2, '.', ',') }}
        </td>
      </tr>
    </tbody>
  </table>
</div>
<style>
  .text-white{
    color: white;
  }

  table#estimation_table{
    border: collapse;
  }

  table#estimation_table tbody tr td{
    text-align: right;
  }

  .text-left{
    text-align: left !important;
  }
</style>
