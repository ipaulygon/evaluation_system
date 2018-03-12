<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Evaluation System | Print Appraisal</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <style type="text/css">
        @page{
            margin-top: 1cm;
            margin-bottom: -0.75cm;
        }
        body{
            font-family: "SegoeUI","Sans-serif";
            font-size: 12px;
        }
        .header{
            font-size: 20px!important;
        }
        .page-break {
            page-break-after: always;
        }
        .center{
            text-align: center;
        }
        .col-md-12{
            width: 100%;
        }
        .col-md-6{
            width: 50%;
        }
        .col-md-4{
            width: 33.33%;
        }
        .border{
            border: 1px solid black;
        }
        .text-right{
            text-align: right;
        }
        table{
            clear: both;
            border: 1px solid black
        }
        tbody tr{
            border: 1px solid black;
            padding: 10px;
        }
        tr:nth-child(even) {
            background-color: #e6e6e6
        }
        thead th{
            background-color: black;
            color: white;
        }
        .footer{
            position: absolute;
            bottom: 0;
            margin-bottom: 60px;
        }
        .footerd{
            font-size: 0.8em;
        }
    </style>
    <body>
        <div class="center header">
            Evaluation System
        </div>
        <div class="col-md-12 border center">
            APPRAISAL
        </div>
        <br>
        <div style="float:left" class="col-md-6">
            Client: {{$appraiseproperty->appraisal->property->seller->first_name}} {{$appraiseproperty->appraisal->property->seller->last_name}}
        </div>
        <div style="float:right" class="col-md-6">
            Appraiser: {{$appraiseproperty->appraisal->appraiser->first_name}} {{$appraiseproperty->appraisal->appraiser->last_name}}
        </div>
        <div style="clear:both"></div>
        <div class="col-md-12">
            <h3>Property Details</h3>
            Property Name: {{$appraiseproperty->appraisal->property->property_name}}<br>
            Property Type: {{($appraiseproperty->appraisal->property->property_type==1 ? 'House and Lot' : 'Lot' )}}<br>
            TCT Number: {{$appraiseproperty->appraisal->property->tct_number}}<br>
            Location: {{$appraiseproperty->appraisal->property->propertylocation->address}}
        </div>
        <hr>
        <div style="float:left" class="col-md-6">
            <h3>Appraisal Info</h3>
            Date of Inspection: {{$appraiseproperty->inspection_date}}<br>
            Date of Appraisal: {{$appraiseproperty->appraisal_date}}<br>
            Registry of Deeds: {{$appraiseproperty->registry_of_deeds}}<br>
            House Model: {{$appraiseproperty->houseModel->house_model}}<br>
            Number of Storeys: {{$appraiseproperty->number_of_storeys}}<br>
            Lot Area: {{number_format($appraiseproperty->appraisal->property->lot_area,2)}} sq. m.<br>
            Remarks: {{$appraiseproperty->remarks}}<br>
        </div>
        <div style="float:right" class="col-md-6">
            <h3>Appraisal Value</h3>
            House Value: PhP {{number_format($appraiseproperty->house_value,2)}}<br>
            Effective Age: {{number_format($appraiseproperty->effective_age)}}<br>
            Total ECO Life: {{number_format($appraiseproperty->total_ecolife)}}<br>
            Remaining ECO Life: {{number_format($appraiseproperty->remaining_ecolife)}}<br>
            Average Lot Value: PhP {{number_format($appraiseproperty->ave_lot_value,2)}}<br>
            Total Lot Value: PhP {{number_format($appraiseproperty->total_lot_value,2)}}<br>
            Total House Value: PhP {{number_format($appraiseproperty->total_house_value,2)}}<br>
            Total Property Value: PhP {{number_format($appraiseproperty->total_property_value,2)}}<br>
        </div>
        <div style="clear:both"></div>
        <br>
        <div class="footer">
            <div style="float:left" class="col-md-6">
                This serves as a copy only.<br>
            </div>
            <div style="float:right;margin-top:-30px!important" class="col-md-6">
                APPRAISER'S SIGNATURE: <br>
            </div>
            <br><br>
            <div class="footerd">Printed {{date('Y-m-d H:m:s')}}</div>
        </div>
    </body>
</html>