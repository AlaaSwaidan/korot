@extends('admin.layouts.master')

@section('title')
    تعديل أمر الشراء
@endsection

@section('page_header')
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">اوامر الشراء</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.purchase-orders.index') }}" class="text-muted text-hover-primary">اوامر الشراء</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">تعديل أمر الشراء</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
@endsection

@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="alert alert-danger alert-dismissable" id="invoice-errors" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            </div>
            <!--begin::Card-->
            <div class="card card-flush">
                {!! Form::model($purchaseOrder, ['method' => 'PATCH', 'url' => route('admin.purchase-orders.update', $purchaseOrder->id),'class' => 'form-horizontal','files'=>'true','id'=>'add-invoice']) !!}
                @include('purchases::purchase_orders._form')
                {!! Form::close() !!}
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
@section('scripts')
    <script src="{{ URL::asset('admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $( "body" ).on( "change", "select[name='supplier_id']", function() {
            var id = $(this).val();

            if(id !== ''){
                var $option = $(this).find(':selected');
                var code = $option.data('code');

                document.getElementById('supplier_code').value=code;
            }else{
                document.getElementById('supplier_code').value="";
            }


        });

        $(document).on('keyup', '.quantity', function (){
            var quantity = $(this).val();
            var index =$(this).parent().parent().index();
            var price =parseFloat(document.getElementById("price["+index+"]").value);
            var tax_percentage =parseFloat(document.getElementById("tax["+index+"]").value);
            var discount_amount =parseFloat(document.getElementById("discount_amount["+index+"]").value);
            var all = quantity * price;
            var percentage = 0;
            if(discount_amount !== 0){
                percentage = all * discount_amount/100;
            }
            all = all - percentage;

            // alert(!Number.isNaN(price));

            /*to get all total of table*/
            if(!Number.isNaN(price)){
                document.getElementById("total["+index+"]").value=(all ).toFixed(2)  ;
                var originalTable = $('table.ItemTable').clone();
                var tds = $(originalTable).children('tbody').children('tr').length;
                let all_total;
                let total_after_tax = '0';
                let total_before_tax = '0' ;
                let total_discount_amount = '0' ;
                let tax_amount = '0' ;
                for (let j = 0; j < tds; j++) {
                    tax_percentage =parseFloat(document.getElementById("tax["+j+"]").value)
                    all_total =parseFloat(document.getElementById("total["+j+"]").value);
                    quantity =parseFloat(document.getElementById("quantity["+index+"]").value);
                    price =parseFloat(document.getElementById("price["+index+"]").value);
                    total_before_tax  = Number(total_before_tax) +all_total;
                    if(tax_percentage !== 0){
                        tax_amount  = parseFloat(tax_amount) + (all_total * tax_percentage / 100 );
                        total_after_tax  = Number(total_after_tax) + (all_total + (all_total * tax_percentage / 100 ));
                        total_discount_amount  =Number(total_discount_amount) +  ((quantity*price) *parseFloat(document.getElementById("discount_amount["+j+"]").value) /100);

                    }else{
                        tax_amount  = parseFloat(tax_amount) + (0 / 100 );
                        total_after_tax  = Number(total_after_tax) + all_total;
                        total_discount_amount  =Number(total_discount_amount) +  ((quantity*price) * parseFloat(document.getElementById("discount_amount["+j+"]").value) /100);

                    }
                }
                document.getElementById('total_before_tax').value =total_before_tax.toFixed(2);
                document.getElementById('tax_amount').value = (tax_amount).toFixed(2);
                document.getElementById('total_after_tax').value = total_after_tax.toFixed(2);
                document.getElementById('total_discount_amount').value = total_discount_amount.toFixed(2);
                /*to get all total of table*/
            }

        });
        $(document).on('keyup', '.price', function (){
            var price = $(this).val();
            var index =$(this).parent().parent().index();
            var quantity =parseFloat(document.getElementById("quantity["+index+"]").value);
            var tax_percentage =parseFloat(document.getElementById("tax["+index+"]").value);

            var discount_amount =parseFloat(document.getElementById("discount_amount["+index+"]").value);
            var all = quantity * price;
            var percentage = 0;
            if(discount_amount !== 0){
                percentage = all * discount_amount/100;
            }
            all = all - percentage;

            // alert();
            /*to get all total of table*/
            document.getElementById("total["+index+"]").value=(all).toFixed(2) ;
            var originalTable = $('table.ItemTable').clone();
            var tds = $(originalTable).children('tbody').children('tr').length;
            let all_total;
            let total_after_tax = '0';
            let total_before_tax = '0' ;
            let total_discount_amount = '0' ;
            let tax_amount = '0' ;
            for (let j = 0; j < tds; j++) {
                tax_percentage =parseFloat(document.getElementById("tax["+j+"]").value)
                all_total =parseFloat(document.getElementById("total["+j+"]").value);
                quantity =parseFloat(document.getElementById("quantity["+index+"]").value);
                price =parseFloat(document.getElementById("price["+index+"]").value);
                total_before_tax  = Number(total_before_tax) +all_total;
                if(tax_percentage !== 0){
                    tax_amount  = parseFloat(tax_amount) + (all_total * tax_percentage / 100 );
                    total_after_tax  = Number(total_after_tax) + (all_total + (all_total * tax_percentage / 100 ));
                    total_discount_amount  =Number(total_discount_amount) +  ((quantity*price) *parseFloat(document.getElementById("discount_amount["+j+"]").value) /100);

                }else{
                    tax_amount  = parseFloat(tax_amount) + (0 / 100 );
                    total_after_tax  = Number(total_after_tax) + all_total;
                    total_discount_amount  =Number(total_discount_amount) +  ((quantity*price) * parseFloat(document.getElementById("discount_amount["+j+"]").value) /100);

                }
            }
            document.getElementById('total_before_tax').value =total_before_tax.toFixed(2);
            document.getElementById('tax_amount').value = (tax_amount).toFixed(2);
            document.getElementById('total_after_tax').value = total_after_tax.toFixed(2);
            document.getElementById('total_discount_amount').value = total_discount_amount.toFixed(2);
            /*to get all total of table*/

        });
        $(document).on('keyup', '.tax_percentage', function (){
            var tax_percentage = $(this).val();
            var index =$(this).parent().parent().index();
            var quantity =parseFloat(document.getElementById("quantity["+index+"]").value);
            var price =parseFloat(document.getElementById("price["+index+"]").value);

            var discount_amount =parseFloat(document.getElementById("discount_amount["+index+"]").value);
            var all = quantity * price;
            var percentage = 0;
            if(discount_amount !== 0){
                percentage = all * discount_amount/100;
            }
            all = all - percentage;

            // alert();
            /*to get all total of table*/
            document.getElementById("total["+index+"]").value=(all).toFixed(2) ;
            var originalTable = $('table.ItemTable').clone();
            var tds = $(originalTable).children('tbody').children('tr').length;
            let all_total;
            let total_after_tax = '0';
            let total_discount_amount = '0' ;
            let total_before_tax = '0' ;
            let tax_amount = '0' ;
            for (let j = 0; j < tds; j++) {
                tax_percentage =parseFloat(document.getElementById("tax["+j+"]").value)
                all_total =parseFloat(document.getElementById("total["+j+"]").value);
                quantity =parseFloat(document.getElementById("quantity["+index+"]").value);
                price =parseFloat(document.getElementById("price["+index+"]").value);
                total_before_tax  = Number(total_before_tax) +all_total;
                if(tax_percentage !== 0){
                    tax_amount  = parseFloat(tax_amount) + (all_total * tax_percentage / 100 );
                    total_after_tax  = Number(total_after_tax) + (all_total + (all_total * tax_percentage / 100 ));
                    total_discount_amount  =Number(total_discount_amount) +  ((quantity*price) *parseFloat(document.getElementById("discount_amount["+j+"]").value) /100);

                }else{
                    tax_amount  = parseFloat(tax_amount) + (0 / 100 );
                    total_after_tax  = Number(total_after_tax) + all_total;
                    total_discount_amount  =Number(total_discount_amount) +  ((quantity*price) * parseFloat(document.getElementById("discount_amount["+j+"]").value) /100);

                }
            }
            document.getElementById('total_before_tax').value =total_before_tax.toFixed(2);
            document.getElementById('tax_amount').value = (tax_amount).toFixed(2);
            document.getElementById('total_after_tax').value = total_after_tax.toFixed(2);
            document.getElementById('total_discount_amount').value = total_discount_amount.toFixed(2);
            /*to get all total of table*/

        });
        $(document).on('keyup', '.discount_amount', function (){
            var discount_amount =parseFloat($(this).val()) ;
            var index =$(this).parent().parent().index();
            var quantity =parseFloat(document.getElementById("quantity["+index+"]").value);
            var price =parseFloat(document.getElementById("price["+index+"]").value);
            var tax_percentage =parseFloat(document.getElementById("tax["+index+"]").value);
            var all = quantity * price;
            var percentage = 0;
            if(discount_amount !== 0){
                percentage = all * discount_amount/100;
            }
            document.getElementById("total["+index+"]").value=((all - percentage )).toFixed(2)  ;
            // alert();
            /*to get all total of table*/
            var originalTable = $('table.ItemTable').clone();
            var tds = $(originalTable).children('tbody').children('tr').length;
            let all_total = '0';
            let total_discount_amount = '0';
            let total_before_tax ='0' ;
            let total_after_tax ='0' ;
            let tax_amount = '0' ;
            for (let j = 0; j < tds; j++) {
                tax_percentage =parseFloat(document.getElementById("tax["+j+"]").value)
                all_total =parseFloat(document.getElementById("total["+j+"]").value);
                quantity =parseFloat(document.getElementById("quantity["+index+"]").value);
                price =parseFloat(document.getElementById("price["+index+"]").value);
                total_before_tax  = Number(total_before_tax) +all_total;
                if(tax_percentage !== 0){
                    tax_amount  = parseFloat(tax_amount) + (all_total * tax_percentage / 100 );
                    total_after_tax  = Number(total_after_tax) + (all_total + (all_total * tax_percentage / 100 ));
                    total_discount_amount  =Number(total_discount_amount) +  ((quantity*price) *parseFloat(document.getElementById("discount_amount["+j+"]").value) /100);

                }else{
                    tax_amount  = parseFloat(tax_amount) + (0 / 100 );
                    total_after_tax  = Number(total_after_tax) + all_total;
                    total_discount_amount  =Number(total_discount_amount) +  ((quantity*price) * parseFloat(document.getElementById("discount_amount["+j+"]").value) /100);

                }
            }
            document.getElementById('total_before_tax').value =total_before_tax.toFixed(2);
            document.getElementById('tax_amount').value = (tax_amount).toFixed(2);
            document.getElementById('total_after_tax').value = total_after_tax.toFixed(2);
            document.getElementById('total_discount_amount').value = total_discount_amount.toFixed(2);
            /*to get all total of table*/
        });



        var i = parseInt(document.getElementById('i_of_id').value);

        $("#addrow2").on("click", function () {
            const unique = (value, index, self) => {
                return self.indexOf(value) === index
            }
            var text =$( "#store_id option:selected" ).val() !== '' ?  $( "#store_id option:selected" ).text() : '';
            $.ajax({
                url: '/admin/get/all-packages',
                type: "GET",
                dataType: "json",
                success: function (data) {

                    if (data['packages'].length > 0) {


                        /*add first row */
                        var newRow = $("<tr>");
                        var cols = "";

                        cols += '<td style="padding: 0;"><div id="accounts_attributes' + i + '" ></div></td>';


                        cols += '<td style="padding: 0;"> <input type="text"  id="quantity[' + i + ']" name="quantity[' + i + ']" class="form-control quantity" placeholder="الكمية" value="" parsley-trigger="change" required > </td>';
                        cols += '<td style="padding: 0;"> <input type="text"  id="price[' + i + ']"   name="price[' + i + ']" class="form-control price" placeholder="السعر" value="" parsley-trigger="change" required > </td>';
                        cols += '<td style="padding: 0;"><select class="form-control selectpicker choose_tax" data-live-search="true"  data-style="btn-light" name="choose_tax[' + i + ']"  > <option value="no_tax" data-index="' + i + '"  >غير شامل الضريبة</option> <option value="with_tax" data-index="' + i + '"  >شامل الضريبة</option> </select> </td>';
                        cols += '<td style="padding: 0;"> <input type="text"  id="tax[' + i + ']" name="tax[' + i + ']" class="form-control tax_percentage" placeholder="الضريبة" value="0" > </td>';
                        cols += '<td style="padding: 0;"> <input type="text"  id="discount_amount[' + i + ']" name="discount_amount[' + i + ']" class="form-control discount_amount" placeholder="نسبة الخصم" value="0" > </td>';
                        cols += '<td style="padding: 0;"> <input type="text"  id="total[' + i + ']"  name="total[' + i + ']" class="form-control total" placeholder="الاجمالي" value="" > </td>';

                        cols += '<td style="padding: 0;"><input type="button" class="ibtnDel btn btn-md btn-danger "  value="{{trans('messages.delete')}}"></td>';
                        newRow.append(cols);

                        $("table.order-list").append(newRow);


                        $('#accounts_attributes' + i).append('<select class="form-control  products" data-live-search="true"  data-style="btn-light"  name="products[' + i + ']" >  <option value="">اختر الباقة</option><option value="digital_balance">الرصيد الرقمي</option>');


                        $.each(data['packages'], function (index, packages) {


                            $('select[name="products[' + i + ']"]').append('<option data-index="'+i+'" data-rc="'+packages.cost+'" value="' + packages.id + '">' + packages.name_ar + '</option>');


                        });
                        $('#accounts_attributes' + i).append(' </select>');


                        i++;


                    }


                }
            });


        });



        $("table.order-list").on("click", ".ibtnDel", function (event) {
            $(this).closest("tr").remove();
            /*to get all total of table*/
            var originalTable = $('table.ItemTable').clone();
            var tds = $(originalTable).children('tbody').children('tr').length;
            let all_total = '0';
            let total_before_tax ;
            for (let j = 0; j < tds; j++) {
                all_total  = Number(all_total) + parseFloat(document.getElementById("total["+j+"]").value);
            }
            let tax = parseFloat(document.getElementById("tax["+0+"]").value);
            total_before_tax = all_total/ (1+(tax/100))
            document.getElementById('total_before_tax').value = total_before_tax.toFixed(2);
            document.getElementById('tax_amount').value = total_before_tax.toFixed(2) * tax /100;
            document.getElementById('total_after_tax').value = all_total;
            /*to get all total of table*/
        });




        function removeAllElements(array, elem) {
            var index = array.indexOf(elem);
            while (index > -1) {
                array.splice(index, 1);
                index = array.indexOf(elem);
            }
        }
    </script>
    <script>
        $(document).on("submit", "#add-invoice", function(event)
        {
            event.preventDefault();
            // document.getElementById('action').value;
            $.ajax({
                url: $(this).attr("action"),
                type: $(this).attr("method"),
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);

                    if (data.success === 0) {
                        $('#invoice-errors').show();
                        var errors = data.error.error.original.error
                        var errors_text = "";
                        for (i = 0; i < errors.length; i++) {
                            // text += errors[i] + "<br>";
                            console.log(errors[i]['value']);
                            errors_text +=errors[i]['value']+"\n";
                        }
                        document.getElementById("invoice-errors").innerHTML =errors_text;

                    }else{

                        window.location.href = data.url;
                    }
                },
                error: function (xhr, desc, err)
                {


                }
            });

        });

    </script>
@endsection
