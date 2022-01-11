var cuentaDetalleTable = $("#cuenta-detalle-table").DataTable({
    "ajax": {
        "type": "GET",
        "url": "/cuentasPorCobrar/getDetalleJson/" + $("#id").val() + "/",
        "data": function (json) {
            return JSON.stringify({ "Sql": 12 });
        },
        "contentType": "application/json; charset=utf-8",
        "dataType": "json",
        "processData": true,
    },
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',


    lengthMenu: [
        [10, 25, 50, -1],
        ["10 filas", "25 filas", "50 filas", "Mostrar todo"],
    ],

    "buttons": [
        "pageLength",
        {
            extend: "excelHtml5",
            filename: "cuenta por Cobrar",
        },
    ],

    paging: true,
    language: {
        sdecimal: ".",
        sthousands: ",",
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_ registros",
        sZeroRecords: "No se encontraron resultados",
        sEmptyTable: "Ningún dato disponible en esta tabla",
        sInfo:
            "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
        sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
        sInfoPostFix: "",
        sSearch: "Buscar:",
        sUrl: "",
        sInfoThousands: ",",
        sLoadingRecords: "Cargando...",
        oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior",
        },
        oAria: {
            sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
            sSortDescending:
                ": Activar para ordenar la columna de manera descendente",
        },
    },
    order: [0, "desc"],

    columns: [
        {
            title: "No.",
            data: "id",
            width: "7%",
            responsivePriority: 1,
            render: function (data, type, full, meta) {
                return data;
            },
        },
        {
            title: "No. Orden",
            data: "credito.no_orden_trabajo",
            width: "10%",
            defaultContent: "No aplica",
            responsivePriority: 3,
            render: function (data, type, full, meta) {
                if (data != null) {
                    return data;
                } else {
                    return full.abono.no_documento;
                }
            },
        },
        {
            title: "Fecha",
            data: "credito.fecha_orden",
            width: "13%",
            responsivePriority: 4,
            render: function (data, type, full, meta) {
                if (data == null) {
                    return full.abono.fecha;
                } else {
                    return data;
                }
            },
        },
        {
            title: "Tipo Transaccion",
            data: "tipo_transaccion.tipo_transaccion",
            width: "15%",
            responsivePriority: 3,
            render: function (data, type, full, meta) {
                //Si es una reversión de abono, imprimir su codigo
                if (full.tipo_transaccion_id == 4) {
                    if (full.abono.no_documento != null) {
                        return (
                            full.tipo_transaccion.tipo_transaccion +
                            " (" +
                            full.abono.no_documento +
                            ")"
                        );
                    } else {
                        return full.tipo_transaccion.tipo_transaccion;
                    }
                } else if (full.tipo_transaccion_id == 3) {
                    return (
                        full.tipo_transaccion.tipo_transaccion +
                        " (" +
                        full.credito.num_factura +
                        ")"
                    );
                } else if (full.tipo_transaccion_id == 2) {
                    if (full.abono.documento_id == 1) {
                        return data + "-" + "Depósito";
                    } else if (full.abono.documento_id == 1) {
                        return data + "-" + "Cheque";
                    } else {
                        return data + "-" + "Efectivo";
                    }
                } else {
                    return data;
                }
            },
        },
        {
            title: "Total",
            data: "total",
            width: "13%",
            responsivePriority: 3,
            render: function (data, type, full, meta) {
                return data;
            },
        },
        {
            title: "Saldo",
            data: "saldo",
            width: "13%",
            responsivePriority: 3,
            render: function (data, type, full, meta) {
                return data;
            },
        },

        // {
        //     title: "Proveedor",
        //     data: "proveedor.nombre_comercial",
        //     width: "20%",
        //     responsivePriority: 2,
        //     render: function (data, type, full, meta) {
        //         return data;
        //     },
        // },
        {
            title: "Acciones",
            orderable: false,
            width: "20%",
            render: function (data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
                if (
                    rol_user == "Super-Administrador" ||
                    rol_user == "Administrador"
                ) {
                    if (full.credito != null) {
                        if (full.estado_id == "1") {
                            if (full.tipo_transaccion_id == "3") {
                                return (
                                    "<div class='text-center float-left col-lg-4'>" +
                                    "<i class='fa fa-warning' title='Reversión'></i>" +
                                    "</a>" +
                                    "</div>"
                                );
                            } else {
                                return (
                                    "<div class='text-center float-left col-lg-6'>" +
                                    "<div id='" +
                                    full.id +
                                    "'class='text-center'>" +
                                    "<div class='float-left col-lg-4'>" +
                                    "<a href='" +
                                    "/ordenequipo/show/" + full.credito_id +
                                    "' class='show-compra' >" +
                                    "<i class='fas fa-info-circle' title='Ver Orden de Trabajo'></i>" +
                                    "</a>" +
                                    "</div>" +
                                    "</div>"
                                );
                            }
                        } else {
                            return (
                                "<div class='text-center float-left col-lg-4'>" +
                                "<i class='fa fa-info' title='Revertido'></i>" +
                                "</a>" +
                                "</div>"
                            );
                        }
                    } else {
                        if (full.estado_id == "1") {
                            if (full.tipo_transaccion_id == "4") {
                                return (
                                    "<div class='text-center float-left col-lg-4'>" +
                                    "<i class='fa fa-warning' title='Reversión'></i>" +
                                    "</a>" +
                                    "</div>"
                                );
                            } else if (full.tipo_transaccion_id == "3") {
                                return (
                                    "<div class='text-center float-left col-lg-4'>" +
                                    "<i class='fa fa-warning' title='Reversión'></i>" +
                                    "</a>" +
                                    "</div>"
                                );
                            } else {
                                return (
                                    "<div class='text-center float-left col-lg-6'>" +
                                    "<div class='col-lg-4'>" +
                                    "<a href='#' class='remove-abono'" +
                                    "data-toggle='modal' data-abono='" +
                                    full.abono.id +
                                    "' data-cuenta='" +
                                    full.cuenta_cobrar_maestro_id +
                                    "' data-cantidad='" +
                                    full.abono.total +
                                    "'data-target='#modalConfirmarAccion' " +
                                    ">" +
                                    "<i class='fa fa-trash' title='Revertir abono'></i>" +
                                    "</a>" +
                                    "</div>" +
                                    "<div id='" + full.id +
                                    "'class='text-center'>" +
                                    "<a href='/cuentasPorCobrarD/pdf/" +
                                    full.id + "-" + $("input[name='clienteID']").val() +
                                    "'>" +
                                    "<i class='fas fa-print' title='Imprimir recibo'></i>" +
                                    "</a>" +
                                   "</div>"
                                );
                            }
                        } else {
                            return (
                                "<div class='text-center float-left col-lg-4'>" +
                                "<i class='fa fa-info' title='Revertido'></i>" +
                                "</a>" +
                                "</div>"
                            );
                        }
                    }
                }
            },
            responsivePriority: 1,
        },
    ],
});

//Revertir abono
$(document).on("click", "a.remove-abono", function (e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    // console.log($this.data("abono"));
    // console.log($this.data("cuenta"));

    alertify.confirm(
        "Revertir abono",
        "Esta seguro que quiere revertir esta transacción de " +
            $this.data("cantidad") +
            "?",
        function () {
            $(".loader").fadeIn();
            $.post({
                type: "POST",
                url:
                    "/cuentasPorCobrar/abono/" +
                    $this.data("abono") +
                    "/cuenta/" +
                    $this.data("cuenta") +
                    "/revertir",
            }).done(function (data) {
                $(".loader").fadeOut(225);
                cuentaDetalleTable.ajax.reload();
                alertify.set("notifier", "position", "top-center");
                alertify.success("Abono revertido con éxito!!");
            });
        },
        function () {
            alertify.set("notifier", "position", "top-center");
            alertify.error("Cancelar");
        }
    );
});
