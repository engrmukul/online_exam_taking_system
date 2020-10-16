$(function () {

    // First, checks if it isn't implemented yet.
    if (!String.prototype.format) {
        String.prototype.format = function () {
            var args = arguments;
            return this.replace(/{(\d+)}/g, function (match, number) {
                return typeof args[number] != 'undefined'
                    ? args[number]
                    : match
                    ;
            });
        };
    }

    var global_selectors = {
        product: $('#product_id'),
        customer: $('#customer_id'),
        quantity: $('#quantity'),
        // inventory: $('#inventory_id')
    }

    var utils = {
        product: {
            as_dict: function (item) {

               // item.stock = 100;

                //var warranty_text = item.warranty > 0 ? 'days' : '';
                //var price_editable = global_selectors.product.data('sale_unit_price');
                return {
                    'id': item.id,
                    'text': item.name,
                    'name': item.name,
                    'stock': item.total_stock,
                    'sale_unit_price': item.sale_unit_price,
                    //'step': item.step_size,
                    'step': 1,
                    //'vat_applicable': item.vat_applicable,
                    //'vat_percentage': item.vat_percentage,
                    //'warranty': item.warranty,
                    // 'warranty_text': warranty_text,
                    // 'price_editable': price_editable,
                    'unit_name': item.units.name
                };
            },
        },
        customer: {
            queryset: function (params) {
                var query = {};
                if ($.isNumeric(params)) {
                    query['mobile'] = params;
                } else {
                    query['name'] = params;
                }
                return query;
            }
        }
    }

    var product = {
        get: function (qs, cb, f_cb) {
            $.ajax({
                url: global_selectors.product.data('url'),
                type: 'GET',
                data: qs,
                dataType: 'json',
                success: function (response) {
                    if (response.length > 0) {
                        var data = response[0];
                        var cb_data = utils.product.as_dict(data);
                        if ($.isFunction(cb)) cb(cb_data);
                    } else {
                        var msg = "Product not found";
                        if ($.isFunction(f_cb)) f_cb(msg);
                    }

                },
                error: function () {
                    var msg = "Something went wrong!";
                    if ($.isFunction(f_cb)) f_cb(msg);
                }
            });
        },
        set_required: function () {
            $(global_selectors.quantity).addClass('text-danger');
            $(global_selectors.quantity).prop('required', true);
            $(global_selectors.product).addClass('text-danger');
        },

        clear_required: function () {
            $(global_selectors.quantity).removeClass('text-danger');
            $(global_selectors.quantity).prop('required', false);
            $(global_selectors.product).removeClass('text-danger');
        }
    }

    var select_options = {
        customer: {
            init: function () {
                $(global_selectors.customer).select2({
                        placeholder: 'Search by name or mobile',
                        minimumInputLength: 2,
                        ajax: {
                            //url: $(global_selectors.customer).data('url'),
                            url: customerListUrl,
                            dataType: 'json',
                            data: function (params) {
                                return utils.customer.queryset(params.term);
                            },
                            processResults: function (data) {
                                if (data) {
                                    var results = $.map(data, function (item) {
                                        return {'id': item.id, 'text': item.name, 'balance': item.balance};
                                    });
                                } else {
                                    results = [];
                                }
                                return {
                                    results: results
                                };
                            },
                            cache: true
                        }
                    }
                );
            },
            get: function () {
                return $(global_selectors.customer).select2('data')[0];
            }
        },
        product: {
            init: function () {
                $(global_selectors.product).select2({
                        placeholder: 'Search Product',
                        minimumInputLength: 1,
                        ajax: {
                            url: $(global_selectors.product).data('url'),
                            dataType: 'json',
                            data: function (params) {
                                //var inventory_id = $(global_selectors.inventory).val();
                                var query = {
                                    name: params.term,
                                    //inventory_id: inventory_id
                                };
                                return query;
                            },
                            processResults: function (data) {
                                if (data) {
                                    var results = $.map(data, function (item) {
                                        return utils.product.as_dict(item);
                                    });
                                } else {
                                    results = [];
                                }

                                return {
                                    results: results
                                };
                            },
                            cache: true
                        }
                    }
                );
            },
            get: function () {
                return $(global_selectors.product).select2('data')[0];
            }
        },
        init: function () {
            this.customer.init();
            this.product.init();
        }
    }
    // initialize select options
    select_options.init();

    var order = {
        selectors: {
            sub_total: $('#total_bill'),
            discount: $('#discount_amount'),
            discount_percent: $('#discount_amount_percent'),
            discount_limit: $('#discount_limit'),
            //vat: $('#vat_amount'),
            total: $('#total_amount'),
            due: $('#total_due'),
            change_amount: $('#change_amount'),
            change_amount_div: $('#changeDiv'),
            sale_date: $('#sale_date'),
            paid: $('#total_paid'),
            quantity: $('#quantity'),
            info_text: $('#info_text'),
            //stock_alert: $('#stock_alert'),
            item_table: $('.item-table'),
            item_body: $('.item-table tbody'),
            item_rows: $('.item-table tbody > tr'),
            items: {
                serial: $('.serial'),
                quantity: $('input[name="quantity[]"]'),
                sale_unit_price: $('input[name="sale_unit_price[]"]'),
                amount: $('input[name="amount[]"]'),
                //vat: $('input[name="vat[]"]'),
                //vat_percent: $('input[name="vat_percent[]"]'),
                //discount_percent: $('input[name="discount_percent[]"]')
            }
        },
        template: function (p) {
            //var vat_percentage = p.vat_percentage ? parseFloat(p.vat_percentage) : 15.00;
            //var step_size = p.step ? parseFloat(p.step).toFixed(2) : 1;
            //var editable = p.price_editable === true ? "" : "readonly";
            var template = '<tr id="{0}">' +
                '<td class="serial"></td>' +
                '<td class="text-left pid">{1}<input type="hidden" name="product_id[]" value="{0}" /></td>' +
                // '<td class="text-right warranty"><input type="text" name="warranty[]" class="form-control text-center" value={9} /> <span> {10} </span></td>' +
                '<td class="text-right quantity"><input type="number" name="quantity[]" min="0" autocomplete="off" class="form-control text-center" value="{2}" /></td>' +
                '<td class="text-right sale_unit_price"><input type="number" name="sale_unit_price[]" autocomplete="off" class="form-control text-center" {3} value="{3}" /></td>' +
                // '<td class="text-right discount_percent"><input type="number" min="0" max="100" name="discount_percent[]" class="form-control text-center" value="{6}" /></td>' +
                // '<td class="text-right discount"><input type="text" name="discount[]" class="form-control text-center" readonly value="{7}" /></td>' +
                // '<td class="text-right vat_percent"><input type="number" min="0" max="100" name="vat_percent[]" class="form-control text-center" value="{4}" /></td>' +
                // '<td class="text-right vat"><input type="text" name="vat[]" class="form-control text-center" readonly value="{5}" /></td>' +
                '<td class="text-right amount"><input type="text" name="amount[]" class="form-control text-center" readonly value="{3}" /></td>' +

                '<td><a class="item-delete" href="#"><i class="ace-icon fa fa-trash-o "></i></a></td>' +
                '</tr>';

            var amount = parseFloat(p.quantity) * parseFloat(p.sale_unit_price || 0);
            //var vat = (amount * vat_percentage) / 100;
            var discount_percent = 0;
            var discount = 0;
            // return template.format(p.id, p.name, p.quantity, parseFloat(p.sale_unit_price || 0).toFixed(2), vat_percentage.toFixed(2),
            //     vat.toFixed(2), discount_percent.toFixed(2), discount.toFixed(2), amount.toFixed(2), p.warranty, p.warranty_text, editable);

            return template.format(p.id, p.name, p.quantity, parseFloat(p.sale_unit_price || 0).toFixed(2), discount.toFixed(2), amount.toFixed(2));
        },
        set_selected: function (p) {
            if (parseFloat(p.stock) > 0.0) {
                // default quantity set to 1
                p.quantity = 1.00;

                $(this.selectors.info_text).html("{0} : Stock is {2} {1}".format(
                    p.name, p.unit_name, parseFloat(p.stock).toFixed(2)));
                $(this.selectors.quantity).val(p.quantity);
                // add single item on product change
                this.push(p);
            } else {
                this.flush_message("out of stock!");
            }

        },
        get_total_quantity: function (product_id) {
            var quantity = 0;
            if ($('tr#' + product_id).length > 0) {
                quantity = $('tr#' + product_id).children('td.quantity').children('input').val();
            }

            quantity = quantity ? quantity : 0;

            return parseFloat(quantity);
        },
        update_amounts: function () {
            var i = 1;
            var subtotal = vat_amount = 0;

            $('.item-table tbody tr').each(function (key, row) {
                $(row).find('.serial').html(i);
                subtotal += parseFloat($(row).find('input[name="amount[]"]').val());
                //vat_amount += parseFloat($(row).find('input[name="vat[]"]').val());
                i++;
            });

            // calculate 15% VAT
            var total = parseFloat(subtotal); //+ parseFloat(vat_amount);

            $(this.selectors.sub_total).val(parseFloat(subtotal).toFixed(2));
            //$(this.selectors.vat).val(parseFloat(vat_amount).toFixed(2));
            $(this.selectors.total).val(parseFloat(total).toFixed(2));
            $(this.selectors.due).val(0.00);
            $(this.selectors.paid).val(parseFloat(total).toFixed(2)).keyup();
        },
        is_item_exists: function (product_id) {
            var item = $(this.selectors.item_table).find('tr[id="' + product_id + '"]');
            return $(item).length > 0;
        },
        get: function (product_id) {
            return $(this.selectors.item_table).find('tr[id="' + product_id + '"]');
        },
        add: function (p) {
            var html = this.template(p);
            this.selectors.item_body.append(html);
            console.log(html)
            // trigger update
            this.update_amounts();
        },
        update: function (product_id, p) {
            var item = this.get(product_id);

            //var vat_percentage = item.children('td.vat_percent').children('input').val();
            //var discount_percent = item.children('td.discount_percent').children('input').val();

            var previous_sale_unit_price = item.children('td.sale_unit_price').children('input').val();
            var previous_quantity = item.children('td.quantity').children('input').val();

            var sale_unit_price = (parseFloat(p.sale_unit_price || 0) + parseFloat(previous_sale_unit_price)) / 2;
            var quantity = parseFloat(p.quantity) + parseFloat(previous_quantity);

            var total_price = sale_unit_price * quantity;
            // var discount = total_price * discount_percent / 100;
            var discount = total_price / 100;
            total_price = total_price - discount;

            var vat = 0;

            /* if (parseFloat(p.vat_applicable) > 0) {
                 vat = (total_price * vat_percentage) / 100;
             }*/

            item.children('td.sale_unit_price').children('input').val(sale_unit_price.toFixed(2));
            item.children('td.quantity').children('input').val(quantity.toFixed(2));
            item.children('td.amount').children('input').val(total_price.toFixed(2));
            // item.children('td.vat').children('input').val(vat.toFixed(2));
            item.children('td.discount').children('input').val(discount.toFixed(2));
            // item.children('td.warranty').children('input').val(p.warranty);
            // item.children('td.warranty').children('span').html(p.warranty_text)

            // // trigger update
            this.update_amounts();
        },
        delete: function (product_id) {
            var element = this.get(product_id);
            element.remove();
            // trigger update
            this.update_amounts();
        },
        put: function (p) {
            if (this.is_item_exists(p.id)) {
                this.update(p.id, p);
            } else {
                this.add(p);
            }
        },
        push: function (p) {
            var total_quantity = this.get_total_quantity(p.id);
            if (parseFloat(p.stock) >= parseFloat(total_quantity)) {
                order.put(p);
                product.clear_required();
                this.flush_message('');
            } else {
                product.set_required();
                if (parseFloat(total_quantity) > p.stock) {
                    $(global_selectors.quantity).val(parseFloat(p.stock).toFixed(2));
                }
                this.flush_message("Out of Stock!");
            }
        },
        observable: {
            product: {
                listen: function () {
                    var self = order;
                    $(global_selectors.product).on('change', function () {
                        // get selected items and set quantity
                        var product = select_options.product.get();
                        order.set_selected(product);
                        $(global_selectors.quantity).prop('step', product.step ? product.step : 1.00);
                    });

                    // Pressing enter in quantity
                    $(self.selectors.quantity).on('keypress', function (event) {
                        $(this).prop('required', true);
                        var keycode = (event.keyCode ? event.keyCode : event.which);

                        // update quantity2
                        var product = select_options.product.get();
                        product.quantity = $(this).val();

                        if (keycode === 13) {
                            var total_quantity = parseFloat(order.get_total_quantity(product.id)) + parseFloat($(this).val());
                            if (parseFloat(product.stock) >= total_quantity) {
                                self.push(product);
                            } else {
                                self.flush_message("out of stock!");
                            }
                            return false;
                        }

                        $(self.selectors.discount_percent).keyup();

                        event.stopPropagation();

                    });
                    // delete item
                    $(self.selectors.item_table).on('click', '.item-delete', function (event) {
                        event.preventDefault();

                        var product_id = $(this).parents('tr').attr('id');
                        self.delete(product_id);
                    });

                    $(self.selectors.item_table).on('keypress', 'input[name="quantity[]"]', function (event) {
                        var keycode = (event.keyCode ? event.keyCode : event.which);
                        if (keycode === 13) {
                            event.preventDefault();
                        }
                    });

                    // Direct change on order item cell
                    //$(self.selectors.item_table).on('keyup mouseup', 'input[name="quantity[]"], input[name="sale_unit_price[]"], input[name="vat_percent[]"], input[name="discount_percent[]"]', function () {
                    $(self.selectors.item_table).on('keyup mouseup', 'input[name="quantity[]"], input[name="sale_unit_price[]"]', function () {

                        var row = $(this).parents('tr').first();

                        product.get({'product_id': $(row).attr('id')}, function (product) {
                            // success callback

                            var quantity = $(row).find('input[name="quantity[]"]').val();
                            var sale_unit_price = $(row).find('input[name="sale_unit_price[]"]').val();
                            //var vat_percentage = $(row).find('input[name="vat_percent[]"]').val();
                            //var discount_percentage = $(row).find('input[name="discount_percent[]"]').val();

                            var total_quantity = self.get_total_quantity($(row).attr('id'));
                            // var vat_percentage = product.vat_percentage ? parseFloat(product.vat_percentage) : 15.00;

                            if (product.stock >= parseFloat(total_quantity)) {
                                //var vat = parseFloat(sale_unit_price * quantity * vat_percentage) / 100;
                                var vat = parseFloat(sale_unit_price * quantity) / 100;
                                var total_price = parseFloat(quantity) * parseFloat(sale_unit_price);
                                //var discount = total_price * discount_percentage / 100;
                                //total_price = (total_price - discount).toFixed(2);
                                total_price = (total_price ).toFixed(2);

                                $(row).find('input[name="amount[]"]').val(parseFloat(total_price).toFixed(2));
                                //$(row).find('input[name="vat[]"]').val(parseFloat(vat).toFixed(2));
                                //$(row).find('input[name="discount[]"]').val(parseFloat(discount).toFixed(2));
                                self.update_amounts();
                                self.flush_message('');
                            } else {
                                self.flush_message("Out of stock!");
                                if (total_quantity > product.stock) {
                                    $(row).find('input[name="quantity[]"]').val(parseFloat(product.stock).toFixed(2));
                                }
                                // alert(parseFloat(total_quantity));
                            }

                        }, function (msg) {
                            // failed callback
                        });

                        $(self.selectors.discount_percent).keyup();

                    });
                }
            },
            discount: {
                track: function () {
                    var self = order;

                    $(self.selectors.discount).on('keyup', function () {
                        var total_bill = $(self.selectors.sub_total).val();
                        var vat_amount = $(self.selectors.vat).val();
                        var total_discount = $(this).val();

                        var parcent_discount = (total_discount * 100) / total_bill;
                        var total_amount = total_bill - total_discount;
                        // var total = parseFloat(total_amount) + parseFloat(vat_amount);
                        var total = parseFloat(total_amount);

                        $(self.selectors.discount_percent).val(parcent_discount.toFixed(4));
                        $(self.selectors.paid).val(total.toFixed(2));
                        $(self.selectors.total).val(total.toFixed(2));
                    });

                    $(self.selectors.discount_percent).on('keyup', function () {
                        var total_bill = parseFloat(self.selectors.sub_total.val());
                        var discount_limit = self.selectors.discount_limit.val();
                        //var vat_amount = $(self.selectors.vat).val();

                        var total_discount_percent = parseFloat($(this).val());
                        if (discount_limit && total_discount_percent > parseFloat(discount_limit)) {
                            $(this).val(discount_limit);
                        }

                        var total_discount_percent = parseFloat($(this).val()) || 0;
                        var total_discount = (total_bill * total_discount_percent) / 100;
                        var total_amount = total_bill - total_discount;
                        //var total = parseFloat(total_amount) + parseFloat(vat_amount);
                        var total = parseFloat(total_amount);

                        $(self.selectors.discount).val(total_discount.toFixed(2));
                        $(self.selectors.total).val(total.toFixed(2));
                        $(self.selectors.paid).val(total.toFixed(2));
                    });
                }
            },
            paid: {
                track: function () {
                    var self = order;
                    $(self.selectors.paid).on('keyup', function () {
                        var total_amount = parseFloat($(self.selectors.total).val() > 0 ? $(self.selectors.total).val() : 0);
                        var total_due = parseFloat($(self.selectors.due).val() > 0 ? $(self.selectors.due).val() : 0);


                        var total_paid = parseFloat($(this).val() || 0);
                        if (total_paid > 0) {

                            var received_amount = parseFloat(total_amount) - parseFloat(total_paid);
                            if (received_amount < 0) {
                                $(self.selectors.change_amount).val(received_amount.toFixed(2));
                                $(self.selectors.due).val(0);
                            } else {
                                $(self.selectors.change_amount).val(0);
                                $(self.selectors.due).val(received_amount);
                            }
                        } else {
                            $(self.selectors.due).val(parseFloat(total_amount).toFixed(2));
                        }
                        $('#number_of_installments').keyup();


                        // Find if there is any due
                        var due_list = $('input[name^="due_paid_amount[]"]');
                        if (due_list.length > 0) {
                            var extra_total = total_amount;
                            var extra_amount = total_paid - total_amount;
                            $.each(due_list, function (index, elem) {
                                $(elem).val(0); // initialize
                                var due = parseFloat($(elem).data('due'));
                                extra_total += due;
                                if (extra_amount > 0) {
                                    if (extra_amount < due) {
                                        $(elem).val(extra_amount.toFixed(2));
                                        extra_amount = 0;
                                    } else {
                                        $(elem).val(due.toFixed(2));
                                        extra_amount = extra_amount - due;
                                    }
                                }
                            });

                            if (total_paid > extra_total) {
                                $(self.selectors.paid).val(parseFloat(extra_total).toFixed(2));
                            }

                            $(order.selectors.change_amount_div).hide();
                        } else {

                            //$(self.selectors.paid).val(total_amount.toFixed(2));
                            $(order.selectors.change_amount_div).show();
                        }

                    });
                }
            },
            /* installment: {
                 selectors: {
                     installment: $('#installment'),
                     number_of_installment: $('#number_of_installments'),
                     is_check: $('#is_installment'),
                     label: $('#label_paid'),
                     amount: $('#installment_amount')

                 },
                 track: function () {
                     var installment = this;
                     //Installment Sales
                     $(this.selectors.installment).hide();

                     $(this.selectors.is_check).on('click', function () {
                         if ($(installment.selectors.is_check).is(':checked')) {
                             $(installment.selectors.installment).show();
                             $(installment.selectors.label).html('Down Payment');
                         } else {
                             $(installment.selectors.installment).hide();
                             $(installment.selectors.label).html('Paid');
                             $(installment.selectors.amount).val('0');
                             $(installment.selectors.number_of_installment).val('0');
                             $('.item-table').next('table').remove();
                         }

                     });

                     $(this.selectors.number_of_installment).keyup(function () {
                         var size = $(this).val();
                         var due = $(order.selectors.due).val();

                         if (size > 0 && due > 0) {
                             var amount = parseFloat(due / size).toFixed(2);
                             installment.generate(size, amount);
                             $(installment.selectors.amount).val(amount);
                         }
                     });
                 },
                 isLeapYear: function (year) {
                     return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
                 },

                 getDaysInMonth: function (year, month) {
                     return [31, (this.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
                 },
                 addMonths: function (date, value) {
                     var d = new Date(date),
                         n = d.getDate();

                     d.setDate(1);
                     d.setMonth(d.getMonth() + value);
                     d.setDate(Math.min(n, this.getDaysInMonth(d.getFullYear(), d.getMonth())));
                     return d.toISOString().split('T')[0];
                 },
                 generate: function (no_of_installments, amount) {
                     var tooltip = '<table class="table table-striped table-bordered table-hover mt-2">' +
                         '<tr><th>Date</th><th>Amount</th></tr>{0}</table>';

                     var tooltip_info = "";

                     var sale_date = $(order.selectors.sale_date).val();
                     for (var i = 1; i <= no_of_installments; i++) {
                         var next_date = this.addMonths(sale_date, i);
                         tooltip_info += "<tr></tr><td>{0}</td><td>{1}</td></tr>".format(next_date, amount);
                     }
                     tooltip = tooltip.format(tooltip_info);
                     $('.item-table').next('table').remove();
                     $(tooltip).insertAfter('.installment-table');

                 }
             }*/
        },
        observe: function () {

            var self = this;
            // change product
            self.observable.product.listen();

            // discount
            self.observable.discount.track();

            // total paid
            self.observable.paid.track();

            // installment
            //self.observable.installment.track();
        },
        flush_message: function (msg) {
            $(this.selectors.stock_alert).html("<span class='text-danger'>" + msg + "</span>");
        }

    }

    // Item observable
    order.observe();

    /* var barcode_reader = {
         selector: $('#barcode'),
         info_text: $("#barcode-info-text"),
         clear: function () {
             $(this.selector).val('');
         },
         listen: function () {
             $(this.selector).on('keypress', function (event) {
                 if (event.keyCode === 13) {
                     event.preventDefault();

                     var dataset = {'barcode': $(this).val()}
                     product.get(dataset,
                         function (data) {
                             var total_quantity = parseFloat(order.get_total_quantity(product.id)) + 1;
                             if (parseFloat(data.stock) >= total_quantity) {
                                 var stock_info = "{0} : Stock is {2} {1}".format(
                                     data.name, data.unit_name, parseFloat(data.stock).toFixed(2));
                                 barcode_reader.info_text.html(stock_info);
                                 // success callback
                                 data.quantity = 1;
                                 order.push(data);
                             } else {
                                 order.flush_message("out of stock!");
                             }

                         },
                         function (msg) {
                             // failed callback
                             order.flush_message(msg);
                         }
                     );
                     barcode_reader.clear();
                 }
             });
         }
     }

     // listening barcode

     barcode_reader.listen();*/


    var invoice = {
        selectors: {
            sale_date: $('#sale_date'),
            invoice: $('#invoice_number')
        },

        change: function () {
            var self = this;
            /*                    $(this.selectors.sale_date).on('change', function () {
                                    var date = $(this).val();
                                   var url = "{{ route('generate-order-number') }}" + '/' + date;
                                    $.get( url, function( data ) {
                                        console.log(data)
                                        $(self.selectors.invoice).val(data);
                                    });
            /!*                        $.ajax({
                                        type: 'GET',
                                        data: {sale_date: date},
                                        url: "{{ route('generate-order-number') }}",
                                        success: function (responseText) {
                                            $(self.selectors.invoice).val(responseText);
                                        }
                                    });*!/
                                });*/
        }
    }

    invoice.change();

    $(global_selectors.customer).on('change', function (e) {
        var selected_customer = $(this).val();
        var customer_balance = parseFloat($(global_selectors.customer).select2('data')[0].balance || 0);

        if (customer_balance > 0) {
            $('#customer_balance').html("Balance: " + customer_balance.toFixed(2));
        } else {
            $('#customer_balance').html('');
        }

        var due_url = customerDueListUrl + '?customer_id={0}'.format(selected_customer);

        $.getJSON(due_url, function (data) {

            var html_contents = '<p><strong>Previous due</strong></p>' +
                '<table class="table table-striped table-bordered table-hover item-table-due"\n' +
                'id="table_due_Id">\n' +
                '<thead>\n' +
                '<tr>\n' +
                '   <th class="text-center" width="15%">Invoice</th>\n' +
                '   <th class="text-center" width="15%">Date</th>\n' +
                '   <th class="text-center" width="15%">Due</th>\n' +
                '   <th class="text-center" width="15%">Paid</th>\n' +
                '</tr>\n' +
                '</thead>\n' +
                '<tbody>\n';
            $.each(data.results, function (index, elem) {
                html_contents += '<tr>' +
                    '<td>' + elem.invoice + '<input type="hidden" name="due_sale_id[]" value="' + elem.id + '" > <input type="hidden" name="due_invoice[]" value="' + elem.invoice + '" > </td>' +
                    '<td>' + elem.sale_date + '<input type="hidden" name="due_sale_date[]" value="' + elem.sale_date + '" > </td>' +
                    '<td class="text-right">' + parseFloat(elem.total_due).toFixed(2) + '<input type="hidden" name="due_due_amount[]" value="' + elem.total_due + '" > </td>' +
                    '<td class="text-right"><input type="number" class="form-control" data-due="' + elem.total_due + '" ' +
                    'max="' + elem.total_due + '" name="due_paid_amount[]" min="0" ></td>' +
                    '</tr>\n';
            });

            html_contents += '</tbody></table>';

            if (data.status_code === 200 && data.results.length > 0) {
                $('#due_list').html(html_contents);
            } else {
                $('#due_list').html('');
            }

            $(order.selectors.paid).keyup();

        });
    });

});
