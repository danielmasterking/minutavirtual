function validarCantidad(index) {
    var precio = $('#txt-precio-' + index).val();
    var cantidad = $('#txt-cantidad-' + index).val();
    if ((precio <= 0 || precio == null || precio == 'undefined') && (cantidad <= 0 || cantidad == null || cantidad == 'undefined')) {
        alert('Cantidad y precio deben ser mayores a 0');
        $('#txt-precio-' + index).focus();
    }
    return;
}

function addMaterial() {
    $('#mermas').prepend('<div class="col-md-12"><div class="col-md-4"><label>Producto</label><input class="form-control" name="txt-material-' + index_material + '"  id="txt-material-' + index_material + '"/></div><div class="col-md-4"><label>Cantidad</label><input class="form-control" value="0" name="txt-cantidad-' + index_material + '"  id="txt-cantidad-' + index_material + '"/></div><div class="col-md-4"><label>Valor</label><input value="0" class="form-control sumar" name="txt-valor-' + index_material + '"  id="txt-valor-' + index_material + '"/></div></div>');
    $('#cantidad-mat').val(index_material);
    index_material++;
    total_recuperado = 0;
    for (i = 1; i < index_material; i++) {
        total_recuperado = total_recuperado + ($('#txt-cantidad-' + i).val() * $('#txt-valor-' + i).val());
    }
    //alert(total_recuperado);
    //escribir total
    $('#total').val(total_recuperado);
    return;
}

function proveedor(selectObj, index) {
    var pro = '';
    for (i = 0; i < len_productos; i++) {
        if ($('#' + selectObj.id).val() == productos[i]['codigo']) {
            pro = productos[i]['proveedor'];
            $('#lbl-' + index).text(pro);
            $('#price-' + index).val(productos[i]['precio']);
        }
    }
}

function puestos(selectObj, index) {
    console.log('executed');
}

function cargarValoresServicio(selectObj, index) {
    var val_id = ids[$('#sel-servicio-' + index + ' option:selected').text()];
    var txt_id = $('#txt-id-' + index);
    txt_id.val(val_id);
}

function finalServicioVariable(selectObj, index) {
    var data = $('#' + selectObj.id).val();
    var jornada_servicio = $('#sel-jornada-' + index).val()
    var total = $('#txt-total-dias-' + index).val();
    //posicion 0 horas (0 - 23)
    //posicion 1 minutos (0 - 59)
    //elemento jornada
    var arr_jornada = jornada_servicio.split(':');
    var hora_jornada = parseInt(arr_jornada[0]);
    var minuto_jornada = parseInt(arr_jornada[1]);
    var hasta = '';
    var hasta_hora = '';
    var hasta_minuto = '';
    //posicion 0 horas (0 - 23)
    //posicion 1 minutos (0 - 59)
    //elemento actual desde
    var arr = data.split(':');
    var hora_desde = parseInt(arr[0]);
    var minuto_desde = parseInt(arr[1]);
    if (hora_desde + hora_jornada >= 24) {
        hasta_hora = hora_desde + hora_jornada - 24;
        if (minuto_desde + minuto_jornada > 60) {
            hasta_minuto = minuto_desde + minuto_jornada - 60;
        } else {
            hasta_minuto = minuto_desde + minuto_jornada;
        }
        if (hasta_minuto < 10) {
            hasta_minuto = '0' + hasta_minuto;
        }
        hasta = hasta_hora + ':' + hasta_minuto;
    } else {
        hasta_hora = hora_desde + hora_jornada;
        if (minuto_desde + minuto_jornada > 60) {
            hasta_minuto = minuto_desde + minuto_jornada - 60;
        } else {
            hasta_minuto = minuto_desde + minuto_jornada;
        }
        /*if( (hora_jornada < 1 && minuto_desde > hasta_minuto) && ((hasta_minuto - minuto_desde + 60) == minuto_jornada)){
		   
		   hasta_hora = hasta_hora + 1;
		   
	   }*/
        if (hasta_minuto < 10) {
            hasta_minuto = '0' + hasta_minuto;
        }
        hasta = hasta_hora + ':' + hasta_minuto;
    }
    $('#label-hasta-' + index).text(hasta);
    $('#txt-hasta-' + index).val(hasta);
    ////////////////////////////////// calculo ftes y precios
    data = $('#sel-jornada-' + index).val();
    var desdeObj = $('#sel-desde-' + index).val();
    var hastaObj = $('#label-hasta-' + index).text();
    var porcentaje = $('#txt-porcentaje-' + index).val();
    var arr = data.split(':');
    var horas = parseInt(arr[0]);
    var minutos = parseInt(arr[1]) / 60;
    var ftes = ((horas + minutos) / 8);
    //Calucular minutos transcurridos en jornada en diurnos y nocturnos;
    var minutos_diurnos = 0;
    var minutos_nocturnos = 0;
    var horas_diurnas = 0;
    var horas_nocturnas = 0;
    //Pos 0 horas
    //Pos 1 minutos
    var array_desde = desdeObj.split(':');
    var hora_desde = parseInt(array_desde[0]);
    var minuto_desde = parseInt(array_desde[1]);
    var array_hasta = hastaObj.split(':');
    var hora_hasta = parseInt(array_hasta[0]);
    var minuto_hasta = parseInt(array_hasta[1]);
    if (hora_hasta <= 12) {
        //Hora Nocturna
        if (hora_hasta <= parseInt(hora_inicio_diurna)) {
            //Hora Nocturna
            horas_nocturnas = hora_hasta - parseInt(hora_inicio_nocturna) + 12;
        } else {
            if (hora_hasta > parseInt(hora_inicio_diurna)) {
                horas_diurnas = hora_hasta - parseInt(hora_inicio_diurna);
            } else {
                horas_diurnas = horas_diurnas + (hora_hasta - parseInt(hora_inicio_diurna))
            }
            //horas_nocturnas = parseInt(hora_inicio_diurna) - parseInt(hora_inicio_nocturna) + 12;			   			  		
        }
        //Hora Diurna
        if (hora_desde >= 12) {
            horas_diurnas = horas_diurnas + parseInt(hora_inicio_nocturna) - hora_desde + 12;
        }
        if (hora_hasta > parseInt(hora_inicio_diurna)) {
            horas_nocturnas = horas - horas_diurnas;
        }
    } else {
        horas_nocturnas = 0;
        horas_diurnas = 0;
        //Hora Diurna
        if (hora_hasta >= parseInt(hora_inicio_diurna)) {
            if (hora_desde >= parseInt(hora_inicio_diurna)) {
                if (hora_desde > hora_hasta) {
                    horas_diurnas = (parseInt(hora_inicio_nocturna) - hora_desde) + 12;
                    //console.log('entro:1');	
                    //console.log(horas_diurnas);
                } else {
                    if (hora_desde == parseInt(hora_inicio_diurna) && hora_hasta != parseInt(hora_inicio_nocturna) + 12 && hora_hasta > parseInt(hora_inicio_nocturna) + 12) {
                        horas_diurnas = hora_hasta - parseInt(hora_desde) - 1;
                        //console.log('entro:2');
                        //console.log(horas_diurnas);
                    } else {
                        horas_diurnas = hora_hasta - parseInt(hora_desde);
                        //console.log('entro:2.5');
                        //console.log(horas_diurnas);
                    }
                }
            } else {
                horas_diurnas = hora_hasta - parseInt(hora_inicio_diurna) - 1;
            }
        }
        //Hora diurna
        if (hora_desde > 12 && hora_hasta <= (parseInt(hora_inicio_nocturna) + 12)) {
            //horas_diurnas = horas_diurnas + (parseInt(hora_inicio_nocturna) - hora_desde) + 12;
            if (hora_hasta < hora_desde && hora_desde < 20) {
                horas_diurnas = horas_diurnas + (hora_desde - parseInt(hora_inicio_diurna)) - 1;
                //console.log('entro:3');
                //console.log(horas_diurnas);	
            } else {
                if (hora_hasta < hora_desde) {
                    horas_diurnas = (hora_desde - parseInt(hora_inicio_diurna)) - horas_diurnas;
                    //console.log('entro:3.5');
                    //console.log(horas_diurnas);				  
                }
            }
        } else {
            if (hora_desde > 12 && (hora_desde + horas_diurnas < (parseInt(hora_inicio_nocturna) + 12))) {
                horas_diurnas = horas_diurnas + (hora_hasta - parseInt(hora_inicio_diurna));
                //  console.log('entro:4');
                // console.log(horas_diurnas);				
            } else {
                if (hora_desde > 12 && hora_desde > hora_hasta) {
                    horas_diurnas = horas_diurnas + (hora_desde - parseInt(hora_inicio_diurna));
                    //console.log('entro:5');
                    //console.log(horas_diurnas);				
                }
            }
        }
        //Hora Nocturna
        if (horas - horas_diurnas > 0) {
            horas_nocturnas = horas - horas_diurnas;
        } else {
            horas_nocturnas = 0;
        }
    }
    //Calucular minutos diurnos y nocturnos
    if (minuto_hasta >= minuto_desde) {
        if (hora_hasta >= parseInt(hora_inicio_diurna) && hora_hasta < parseInt(hora_inicio_nocturna) + 12) {
            //minuto diurno
            minutos_diurnos = minuto_hasta - minuto_desde;
        }
        if (hora_hasta < parseInt(hora_inicio_diurna)) {
            if (hora_desde >= parseInt(hora_inicio_nocturna) + 12) {
                minutos_nocturnos = minuto_hasta - minuto_desde;
            } else {
                if (hora_hasta < hora_desde) {
                    //comienza en diurna y termina en nocturna
                    if (minuto_desde == 0) {
                        minutos_nocturnos = minuto_hasta;
                    } else {
                        //restar una hora diurna y calcular minutos diurnos
                        horas_diurnas = horas_diurnas - 1;
                        minutos_diurnos = 60 - minuto_desde;
                        minutos_nocturnos = minuto_hasta;
                    }
                }
            }
        } else {
            if (hora_desde >= parseInt(hora_inicio_nocturna) + 12) {
                minutos_nocturnos = minuto_hasta - minuto_desde;
            } else {
                if (hora_desde >= parseInt(hora_inicio_diurna) && hora_hasta >= parseInt(hora_inicio_nocturna) + 12) {
                    //comienza en diurna y termina en nocturna
                    if (minuto_desde == 0) {
                        minutos_nocturnos = minuto_hasta;
                    } else {
                        //restar una hora diurna y calcular minutos diurnos
                        horas_diurnas = horas_diurnas - 1;
                        minutos_diurnos = 60 - minuto_desde;
                        minutos_nocturnos = minuto_hasta;
                    }
                } else {
                    //hora desde menor a hora diurna
                    if (minuto_desde > 0) {
                        minutos_nocturnos = parseInt(minuto_inicio_diurna) - minuto_desde + 60;
                        if (hora_hasta >= parseInt(hora_inicio_diurna)) {
                            horas_nocturnas = horas_nocturnas - 1;
                        }
                    }
                    if (minuto_hasta > 0) {
                        minutos_diurnos = minuto_hasta - parseInt(minuto_inicio_diurna);
                    }
                }
            }
        }
    } else {
        //minuto hasta menor
        if (hora_hasta >= parseInt(hora_inicio_diurna) && hora_hasta < parseInt(hora_inicio_nocturna) + 12) {
            //minuto diurno
            minutos_diurnos = minuto_hasta - minuto_desde + 60;
            if (hora_hasta > hora_desde) {
                horas_diurnas = horas_diurnas - 1;
            }
        }
        if (hora_hasta < parseInt(hora_inicio_diurna)) {
            if (hora_desde >= parseInt(hora_inicio_nocturna) + 12) {
                minutos_nocturnos = minuto_hasta - minuto_desde;
            } else {
                if (hora_hasta < hora_desde) {
                    //comienza en diurna y termina en nocturna
                    if (minuto_desde == 0) {
                        minutos_nocturnos = minuto_hasta;
                    } else {
                        //restar una hora diurna y calcular minutos diurnos
                        horas_diurnas = horas_diurnas - 1;
                        minutos_diurnos = 60 - minuto_desde;
                        minutos_nocturnos = minuto_hasta;
                    }
                }
            }
        } else {
            if (hora_desde >= parseInt(hora_inicio_nocturna) + 12) {
                minutos_nocturnos = minuto_hasta - minuto_desde;
            } else {
                if (hora_desde >= parseInt(hora_inicio_diurna) && hora_hasta >= parseInt(hora_inicio_nocturna) + 12) {
                    //comienza en diurna y termina en nocturna
                    if (minuto_desde == 0) {
                        minutos_nocturnos = minuto_hasta;
                    } else {
                        //restar una hora diurna y calcular minutos diurnos
                        horas_diurnas = horas_diurnas - 1;
                        minutos_diurnos = 60 - minuto_desde;
                        minutos_nocturnos = minuto_hasta;
                    }
                }
            }
            //comienza nocturna termina en diurna
        }
    }
    //Verificar turno seleccionado diurno/nocturno
    var txt_selected = $('#sel-servicio-' + index + ' option:selected').text();
    total = Math.round(total);
    ftes = ($('#txt-cant-' + index).val()) * ((total * ftes) / 30);
    ftes = (ftes * porcentaje) / 100;
    ftes = parseFloat(ftes).toFixed(2);
    if (txt_selected.indexOf("Nocturno") === -1) {
        //Turno diurno seleccionado
        //Valor Diurno	
        var valor_mes_servicio_diurno = parseFloat(precios[txt_selected]);
        var valor_dia_servicio_diurno = parseFloat(valor_mes_servicio_diurno / 30);
        var valor_hora_servicio_diurno = parseFloat(valor_dia_servicio_diurno / 8);
        var valor_minuto_servicio_diurno = parseFloat(valor_hora_servicio_diurno / 60);
        valor_minuto_servicio_diurno = valor_minuto_servicio_diurno;
        //Valor Nocturno
        //obtener selector para precio de valor diurno
        var array_tmp = txt_selected.split(' ');
        txt_selected = '';
        var tam = array_tmp.length - 1;
        for (i = 0; i < tam; i++) {
            txt_selected = (i == tam - 1) ? txt_selected + array_tmp[i] : txt_selected + array_tmp[i] + ' ';
        }
        txt_selected = txt_selected + ' Nocturno';
        var valor_mes_servicio_nocturno = parseFloat(precios[txt_selected]);
        var valor_dia_servicio_nocturno = parseFloat(valor_mes_servicio_nocturno / 30);
        var valor_hora_servicio_nocturno = parseFloat(valor_dia_servicio_nocturno / 8);
        var valor_minuto_servicio_nocturno = parseFloat(valor_hora_servicio_nocturno / 60);
        valor_minuto_servicio_nocturno = valor_minuto_servicio_nocturno;
    } else {
        //Turno Nocurno seleccionado
        //Valor Nocturno
        var valor_mes_servicio_nocturno = parseFloat(precios[txt_selected]);
        var valor_dia_servicio_nocturno = parseFloat(valor_mes_servicio_nocturno / 30);
        var valor_hora_servicio_nocturno = parseFloat(valor_dia_servicio_nocturno / 8);
        var valor_minuto_servicio_nocturno = parseFloat(valor_hora_servicio_nocturno / 60);
        valor_minuto_servicio_nocturno = valor_minuto_servicio_nocturno;
        //obtener selector para precio de valor diurno
        var array_tmp = txt_selected.split(' ');
        txt_selected = '';
        var tam = array_tmp.length - 1;
        for (i = 0; i < tam; i++) {
            txt_selected = (i == tam - 1) ? txt_selected + array_tmp[i] : txt_selected + array_tmp[i] + ' ';
        }
        txt_selected = txt_selected + ' Diurno';
        //Valor Diurno
        //Valor Diurno
        var valor_mes_servicio_diurno = parseFloat(precios[txt_selected]);
        var valor_dia_servicio_diurno = parseFloat(valor_mes_servicio_diurno / 30);
        var valor_hora_servicio_diurno = parseFloat(valor_dia_servicio_diurno / 8);
        var valor_minuto_servicio_diurno = parseFloat(valor_hora_servicio_diurno / 60);
        valor_minuto_servicio_diurno = valor_minuto_servicio_diurno;
    }
    var minutos_servicio_diurno = ((horas_diurnas * 60) + minutos_diurnos);
    var minutos_servicio_nocturno = ((horas_nocturnas * 60) + minutos_nocturnos);
    var valor_mes_servicio = total * ((minutos_servicio_diurno * valor_minuto_servicio_diurno) + (minutos_servicio_nocturno * valor_minuto_servicio_nocturno));
    valor_mes_servicio = valor_mes_servicio * ($('#txt-cant-' + index).val());
    valor_mes_servicio = Math.round(valor_mes_servicio);
    $('#label-dias-' + index).text(total);
    $('#label-ftes-' + index).text(ftes);
    $('#label-precio-' + index).text(valor_mes_servicio);
    $('#txt-dias-' + index).val(total);
    $('#txt-ftes-' + index).val(ftes);
    $('#txt-precio-' + index).val(valor_mes_servicio);
    console.log('minutos_mes_diurno: ' + minutos_servicio_diurno + ' horas diurnas: ' + horas_diurnas + ' valor: ' + valor_minuto_servicio_diurno);
    console.log('minutos_mes_nocturno: ' + minutos_servicio_nocturno + ' horas nocturnas: ' + horas_nocturnas + ' valor: ' + valor_minuto_servicio_nocturno);
    console.log('Horas Diurnas: ' + horas_diurnas);
    console.log('Horas Nocturnas: ' + horas_nocturnas);
    console.log('Minutos Diurnos: ' + minutos_diurnos);
    console.log('Minutos Nocturnos: ' + minutos_nocturnos);
}

function totalDias(selectObj, index) {
    //var total = parseFloat($('#label-dias-'+index).text());
    var total = 0;
    var dias_sin_festivos_mes = dias_sin_festivos / 12;
    var dias_sin_festivos_semana = dias_sin_festivos_mes / 7;
    var dias_festivos_ano = dias_festivos / 12;
    var temp = selectObj.id.split('-');
    var data = $('#sel-jornada-' + index).val();
    var desdeObj = $('#sel-desde-' + index).val();
    var hastaObj = $('#label-hasta-' + index).text();
    var porcentaje = $('#txt-porcentaje-' + index).val();
    var arr = data.split(':');
    var horas = parseInt(arr[0]);
    var minutos = parseInt(arr[1]) / 60;
    var ftes = ((horas + minutos) / 8);
    var lunes = $('#check-lunes-' + index);
    var martes = $('#check-martes-' + index);
    var miercoles = $('#check-miercoles-' + index);
    var jueves = $('#check-jueves-' + index);
    var viernes = $('#check-viernes-' + index);
    var sabado = $('#check-sabado-' + index);
    var domingo = $('#check-domingo-' + index);
    var festivo = $('#check-festivo-' + index);
    //Calucular minutos transcurridos en jornada en diurnos y nocturnos;
    var minutos_diurnos = 0;
    var minutos_nocturnos = 0;
    var horas_diurnas = 0;
    var horas_nocturnas = 0;
    //Pos 0 horas
    //Pos 1 minutos
    var array_desde = desdeObj.split(':');
    var hora_desde = parseInt(array_desde[0]);
    var minuto_desde = parseInt(array_desde[1]);
    var array_hasta = hastaObj.split(':');
    var hora_hasta = parseInt(array_hasta[0]);
    var minuto_hasta = parseInt(array_hasta[1]);
    if (hora_hasta <= 12) {
        //Hora Nocturna
        if (hora_hasta <= parseInt(hora_inicio_diurna)) {
            //Hora Nocturna
            horas_nocturnas = hora_hasta - parseInt(hora_inicio_nocturna) + 12;
        } else {
            if (hora_hasta > parseInt(hora_inicio_diurna)) {
                horas_diurnas = hora_hasta - parseInt(hora_inicio_diurna);
            } else {
                horas_diurnas = horas_diurnas + (hora_hasta - parseInt(hora_inicio_diurna))
            }
            //horas_nocturnas = parseInt(hora_inicio_diurna) - parseInt(hora_inicio_nocturna) + 12;			   			  		
        }
        //Hora Diurna
        if (hora_desde >= 12) {
            horas_diurnas = horas_diurnas + parseInt(hora_inicio_nocturna) - hora_desde + 12;
        }
        if (hora_hasta > parseInt(hora_inicio_diurna)) {
            horas_nocturnas = horas - horas_diurnas;
        }
    } else {
        horas_nocturnas = 0;
        horas_diurnas = 0;
        //Hora Diurna
        if (hora_hasta >= parseInt(hora_inicio_diurna)) {
            if (hora_desde >= parseInt(hora_inicio_diurna)) {
                if (hora_desde > hora_hasta) {
                    horas_diurnas = (parseInt(hora_inicio_nocturna) - hora_desde) + 12;
                    //console.log('entro:1');	
                    //console.log(horas_diurnas);
                } else {
                    if (hora_desde == parseInt(hora_inicio_diurna) && hora_hasta != parseInt(hora_inicio_nocturna) + 12 && hora_hasta > parseInt(hora_inicio_nocturna) + 12) {
                        horas_diurnas = hora_hasta - parseInt(hora_desde) - 1;
                        //console.log('entro:2');
                        //console.log(horas_diurnas);
                    } else {
                        horas_diurnas = hora_hasta - parseInt(hora_desde);
                        //console.log('entro:2.5');
                        //console.log(horas_diurnas);
                    }
                }
            } else {
                horas_diurnas = hora_hasta - parseInt(hora_inicio_diurna) - 1;
            }
        }
        //Hora diurna
        if (hora_desde > 12 && hora_hasta <= (parseInt(hora_inicio_nocturna) + 12)) {
            //horas_diurnas = horas_diurnas + (parseInt(hora_inicio_nocturna) - hora_desde) + 12;
            if (hora_hasta < hora_desde && hora_desde < 20) {
                horas_diurnas = horas_diurnas + (hora_desde - parseInt(hora_inicio_diurna)) - 1;
                //console.log('entro:3');
                //console.log(horas_diurnas);	
            } else {
                if (hora_hasta < hora_desde) {
                    horas_diurnas = (hora_desde - parseInt(hora_inicio_diurna)) - horas_diurnas;
                    //console.log('entro:3.5');
                    //console.log(horas_diurnas);				  
                }
            }
        } else {
            if (hora_desde > 12 && (hora_desde + horas_diurnas < (parseInt(hora_inicio_nocturna) + 12))) {
                horas_diurnas = horas_diurnas + (hora_hasta - parseInt(hora_inicio_diurna));
                //  console.log('entro:4');
                // console.log(horas_diurnas);				
            } else {
                if (hora_desde > 12 && hora_desde > hora_hasta) {
                    horas_diurnas = horas_diurnas + (hora_desde - parseInt(hora_inicio_diurna));
                    //console.log('entro:5');
                    //console.log(horas_diurnas);				
                }
            }
        }
        //Hora Nocturna
        if (horas - horas_diurnas > 0) {
            horas_nocturnas = horas - horas_diurnas;
        } else {
            horas_nocturnas = 0;
        }
    }
    //Calucular minutos diurnos y nocturnos
    if (minuto_hasta >= minuto_desde) {
        if (hora_hasta >= parseInt(hora_inicio_diurna) && hora_hasta < parseInt(hora_inicio_nocturna) + 12) {
            //minuto diurno
            minutos_diurnos = minuto_hasta - minuto_desde;
        }
        if (hora_hasta < parseInt(hora_inicio_diurna)) {
            if (hora_desde >= parseInt(hora_inicio_nocturna) + 12) {
                minutos_nocturnos = minuto_hasta - minuto_desde;
            } else {
                if (hora_hasta < hora_desde) {
                    //comienza en diurna y termina en nocturna
                    if (minuto_desde == 0) {
                        minutos_nocturnos = minuto_hasta;
                    } else {
                        //restar una hora diurna y calcular minutos diurnos
                        horas_diurnas = horas_diurnas - 1;
                        minutos_diurnos = 60 - minuto_desde;
                        minutos_nocturnos = minuto_hasta;
                    }
                }
            }
        } else {
            if (hora_desde >= parseInt(hora_inicio_nocturna) + 12) {
                minutos_nocturnos = minuto_hasta - minuto_desde;
            } else {
                if (hora_desde >= parseInt(hora_inicio_diurna) && hora_hasta >= parseInt(hora_inicio_nocturna) + 12) {
                    //comienza en diurna y termina en nocturna
                    if (minuto_desde == 0) {
                        minutos_nocturnos = minuto_hasta;
                    } else {
                        //restar una hora diurna y calcular minutos diurnos
                        horas_diurnas = horas_diurnas - 1;
                        minutos_diurnos = 60 - minuto_desde;
                        minutos_nocturnos = minuto_hasta;
                    }
                } else {
                    //hora desde menor a hora diurna
                    if (minuto_desde > 0) {
                        minutos_nocturnos = parseInt(minuto_inicio_diurna) - minuto_desde + 60;
                        if (hora_hasta >= parseInt(hora_inicio_diurna)) {
                            horas_nocturnas = horas_nocturnas - 1;
                        }
                    }
                    if (minuto_hasta > 0) {
                        minutos_diurnos = minuto_hasta - parseInt(minuto_inicio_diurna);
                    }
                }
            }
        }
    } else {
        //minuto hasta menor
        if (hora_hasta >= parseInt(hora_inicio_diurna) && hora_hasta < parseInt(hora_inicio_nocturna) + 12) {
            //minuto diurno
            minutos_diurnos = minuto_hasta - minuto_desde + 60;
            if (hora_hasta > hora_desde) {
                horas_diurnas = horas_diurnas - 1;
            }
        }
        if (hora_hasta < parseInt(hora_inicio_diurna)) {
            if (hora_desde >= parseInt(hora_inicio_nocturna) + 12) {
                minutos_nocturnos = minuto_hasta - minuto_desde;
            } else {
                if (hora_hasta < hora_desde) {
                    //comienza en diurna y termina en nocturna
                    if (minuto_desde == 0) {
                        minutos_nocturnos = minuto_hasta;
                    } else {
                        //restar una hora diurna y calcular minutos diurnos
                        horas_diurnas = horas_diurnas - 1;
                        minutos_diurnos = 60 - minuto_desde;
                        minutos_nocturnos = minuto_hasta;
                    }
                }
            }
        } else {
            if (hora_desde >= parseInt(hora_inicio_nocturna) + 12) {
                minutos_nocturnos = minuto_hasta - minuto_desde;
            } else {
                if (hora_desde >= parseInt(hora_inicio_diurna) && hora_hasta >= parseInt(hora_inicio_nocturna) + 12) {
                    //comienza en diurna y termina en nocturna
                    if (minuto_desde == 0) {
                        minutos_nocturnos = minuto_hasta;
                    } else {
                        //restar una hora diurna y calcular minutos diurnos
                        horas_diurnas = horas_diurnas - 1;
                        minutos_diurnos = 60 - minuto_desde;
                        minutos_nocturnos = minuto_hasta;
                    }
                }
            }
            //comienza nocturna termina en diurna
        }
    }
    if (lunes.is(':checked')) {
        //total = total + dias_sin_festivos_semana;
        total = total + 4;
    }
    if (martes.is(':checked')) {
        //total = total + dias_sin_festivos_semana;
        total = total + 4;
    }
    if (miercoles.is(':checked')) {
        //total = total + dias_sin_festivos_semana;
        total = total + 4;
    }
    if (jueves.is(':checked')) {
        //total = total + dias_sin_festivos_semana;
        total = total + 4;
    }
    if (viernes.is(':checked')) {
        //total = total + dias_sin_festivos_semana;
        total = total + 4;
    }
    if (sabado.is(':checked')) {
        //total = total + dias_sin_festivos_semana;
        total = total + 4;
    }
    if (domingo.is(':checked')) {
        //total = total + dias_sin_festivos_semana;
        total = total + 4;
    }
    if (festivo.is(':checked')) {
        //total = total + dias_festivos_ano;
        total = total + 2;
    }
    //Verificar turno seleccionado diurno/nocturno
    var txt_selected = $('#sel-servicio-' + index + ' option:selected').text();
    total = Math.round(total);
    ftes = ($('#txt-cant-' + index).val()) * ((total * ftes) / 30);
    ftes = (ftes * porcentaje) / 100;
    ftes = parseFloat(ftes).toFixed(2);
    if (txt_selected.indexOf("Nocturno") === -1) {
        //Turno diurno seleccionado
        //Valor Diurno	
        var valor_mes_servicio_diurno = parseFloat(precios[txt_selected]);
        var valor_dia_servicio_diurno = parseFloat(valor_mes_servicio_diurno / 30);
        var valor_hora_servicio_diurno = parseFloat(valor_dia_servicio_diurno / 8);
        var valor_minuto_servicio_diurno = parseFloat(valor_hora_servicio_diurno / 60);
        valor_minuto_servicio_diurno = valor_minuto_servicio_diurno;
        //Valor Nocturno
        //obtener selector para precio de valor diurno
        var array_tmp = txt_selected.split(' ');
        txt_selected = '';
        var tam = array_tmp.length - 1;
        for (i = 0; i < tam; i++) {
            txt_selected = (i == tam - 1) ? txt_selected + array_tmp[i] : txt_selected + array_tmp[i] + ' ';
        }
        txt_selected = txt_selected + ' Nocturno';
        var valor_mes_servicio_nocturno = parseFloat(precios[txt_selected]);
        var valor_dia_servicio_nocturno = parseFloat(valor_mes_servicio_nocturno / 30);
        var valor_hora_servicio_nocturno = parseFloat(valor_dia_servicio_nocturno / 8);
        var valor_minuto_servicio_nocturno = parseFloat(valor_hora_servicio_nocturno / 60);
        valor_minuto_servicio_nocturno = valor_minuto_servicio_nocturno;
    } else {
        //Turno Nocurno seleccionado
        //Valor Nocturno
        var valor_mes_servicio_nocturno = parseFloat(precios[txt_selected]);
        var valor_dia_servicio_nocturno = parseFloat(valor_mes_servicio_nocturno / 30);
        var valor_hora_servicio_nocturno = parseFloat(valor_dia_servicio_nocturno / 8);
        var valor_minuto_servicio_nocturno = parseFloat(valor_hora_servicio_nocturno / 60);
        valor_minuto_servicio_nocturno = valor_minuto_servicio_nocturno;
        //obtener selector para precio de valor diurno
        var array_tmp = txt_selected.split(' ');
        txt_selected = '';
        var tam = array_tmp.length - 1;
        for (i = 0; i < tam; i++) {
            txt_selected = (i == tam - 1) ? txt_selected + array_tmp[i] : txt_selected + array_tmp[i] + ' ';
        }
        txt_selected = txt_selected + ' Diurno';
        //Valor Diurno
        //Valor Diurno
        var valor_mes_servicio_diurno = parseFloat(precios[txt_selected]);
        var valor_dia_servicio_diurno = parseFloat(valor_mes_servicio_diurno / 30);
        var valor_hora_servicio_diurno = parseFloat(valor_dia_servicio_diurno / 8);
        var valor_minuto_servicio_diurno = parseFloat(valor_hora_servicio_diurno / 60);
        valor_minuto_servicio_diurno = valor_minuto_servicio_diurno;
    }
    var minutos_servicio_diurno = ((horas_diurnas * 60) + minutos_diurnos);
    var minutos_servicio_nocturno = ((horas_nocturnas * 60) + minutos_nocturnos);
    var valor_mes_servicio = total * ((minutos_servicio_diurno * valor_minuto_servicio_diurno) + (minutos_servicio_nocturno * valor_minuto_servicio_nocturno));
    valor_mes_servicio = valor_mes_servicio * ($('#txt-cant-' + index).val());
    valor_mes_servicio = Math.round(valor_mes_servicio);
    $('#label-dias-' + index).text(total);
    $('#label-ftes-' + index).text(ftes);
    $('#label-precio-' + index).text(valor_mes_servicio);
    $('#txt-dias-' + index).val(total);
    $('#txt-ftes-' + index).val(ftes);
    $('#txt-precio-' + index).val(valor_mes_servicio);
    console.log('minutos_mes_diurno: ' + minutos_servicio_diurno + ' horas diurnas: ' + horas_diurnas + ' valor: ' + valor_minuto_servicio_diurno);
    console.log('minutos_mes_nocturno: ' + minutos_servicio_nocturno + ' horas nocturnas: ' + horas_nocturnas + ' valor: ' + valor_minuto_servicio_nocturno);
    console.log('Horas Diurnas: ' + horas_diurnas);
    console.log('Horas Nocturnas: ' + horas_nocturnas);
    console.log('Minutos Diurnos: ' + minutos_diurnos);
    console.log('Minutos Nocturnos: ' + minutos_nocturnos);
}

function finalServicio(selectObj, index) {
    var data = $('#' + selectObj.id).val();
    var jornada_servicio = $('#sel-jornada-' + index).val()
    //posicion 0 horas (0 - 23)
    //posicion 1 minutos (0 - 59)
    //elemento jornada
    var arr_jornada = jornada_servicio.split(':');
    var hora_jornada = parseInt(arr_jornada[0]);
    var minuto_jornada = parseInt(arr_jornada[1]);
    var hasta = '';
    var hasta_hora = '';
    var hasta_minuto = '';
    //posicion 0 horas (0 - 23)
    //posicion 1 minutos (0 - 59)
    //elemento actual desde
    var arr = data.split(':');
    var hora_desde = parseInt(arr[0]);
    var minuto_desde = parseInt(arr[1]);
    if (hora_desde + hora_jornada >= 24) {
        hasta_hora = hora_desde + hora_jornada - 24;
        if (minuto_desde + minuto_jornada > 60) {
            hasta_minuto = minuto_desde + minuto_jornada - 60;
        } else {
            hasta_minuto = minuto_desde + minuto_jornada;
        }
        if (hasta_minuto < 10) {
            hasta_minuto = '0' + hasta_minuto;
        }
        hasta = hasta_hora + ':' + hasta_minuto;
    } else {
        hasta_hora = hora_desde + hora_jornada;
        if (minuto_desde + minuto_jornada > 60) {
            hasta_minuto = minuto_desde + minuto_jornada - 60;
        } else {
            hasta_minuto = minuto_desde + minuto_jornada;
        }
        /*if( (hora_jornada < 1 && minuto_desde > hasta_minuto) && ((hasta_minuto - minuto_desde + 60) == minuto_jornada)){
		   
		   hasta_hora = hasta_hora + 1;
		   
	   }*/
        if (hasta_minuto < 10) {
            hasta_minuto = '0' + hasta_minuto;
        }
        hasta = hasta_hora + ':' + hasta_minuto;
    }
    $('#label-hasta-' + index).text(hasta);
    $('#txt-hasta-' + index).val(hasta);
}

function calculaFtes(selectObj, index) {
    /*var data = $('#'+selectObj.id).val();
	var arr = data.split(':');
	var horas = parseInt(arr[0]);
	var minutos = parseInt(arr[1])/60;
    
	var ftes = ((horas + minutos)/8 ) * $('#txt-cant-'+index).val();
	ftes = parseFloat(ftes).toFixed(2);
	
   $('#label-ftes-'+index).text(ftes);*/
}

function manejoEspecial(selectObj, index) {
    if ($('#' + selectObj.id).val() != '1' && $('#' + selectObj.id).val() != '2' && $('#' + selectObj.id).val() != '3') {
        $('#file-cot-' + index).prop('disabled', 'disabled');
        $('#txt-prod-' + index).val($('#' + selectObj.id + ' option:selected').text());
        $('#txt-prod-' + index).prop('readonly', 'readonly');
        $('#txt-precio-' + index).prop('readonly', 'readonly');
        $('#txt-precio-' + index).maskMoney('destroy');
        $('#txt-proveedor-' + index).prop('readonly', 'readonly');
    } else {
        $('#file-cot-' + index).prop('disabled', null);
        $('#txt-prod-' + index).val('');
        $('#txt-prod-' + index).prop('readonly', null);
        $('#txt-precio-' + index).prop('readonly', null);
        $("#txt-precio-" + index).maskMoney({thousands:'.', decimal:',', precision: 0, allowZero:false, allowNegative:false, suffix: ''});
        $('#txt-proveedor-' + index).prop('readonly', null);
    }
    for (i = 0; i < len_productos; i++) {
        if ($('#' + selectObj.id).val() == productos[i]['codigo']) {
            $('#price-' + index).val(productos[i]['precio']);
        }
    }
}
$(document).ready(function() {
    $('#w0-disp').prop('placeholder', 'Fecha Inicial');
    $('#w1-disp').prop('placeholder', 'Fecha Final');
    if ($('#capacitacion-novedad_id').length > 0) {
        $('#ocultar').removeClass("show");
        $('#ocultar').addClass("hidden");
        $('#capacitacion-novedad_id').on('change', function() {
            if ($('#capacitacion-novedad_id').val() == '23' || $('#capacitacion-novedad_id').val() == '24') {
                $('#todas').prop('disabled', null);
                $('#cordinador').prop('disabled', null);
                $('#ocultar').removeClass("hidden");
                $('#ocultar').addClass("show");
            } else {
                $('#todas').prop('disabled', 'disabled');
                $('#cordinador').prop('disabled', 'disabled');
                $('#ocultar').removeClass("show");
                $('#ocultar').addClass("hidden");
            }
        });
    }
    if ($('#visitadia-responsable').length > 0) {
        $('#visitadia-responsable').on('change', function() {
            if ($('#visitadia-responsable').val() == 'OTRO') {
                $('#visitadia-otro').prop('readonly', null);
            } else {
                $('#visitadia-otro').prop('readonly', 'readonly');
            }
        });
    }
    if ($('#visitamensual-atendio').length > 0) {
        $('#visitamensual-atendio').on('change', function() {
            if ($('#visitamensual-atendio').val() == 'OTRO') {
                $('#visitamensual-otro').prop('readonly', null);
            } else {
                $('#visitamensual-otro').prop('readonly', 'readonly');
            }
        });
    }
    if ($('#comite-novedad_id').length > 0) {
        $('#comite-novedad_id').on('change', function() {
            if ($('#comite-novedad_id').val() == '28') {
                $('#marca').removeClass("hidden");
                $('#marca').addClass("show");
                $('#dependencia').removeClass("show");
                $('#dependencia').addClass("hidden");
                $('#add-cor').removeClass("show");
                $('#add-cor').addClass("hidden");
            } else {
                if ($('#comite-novedad_id').val() == '27') {
                    $('#dependencia').removeClass("hidden");
                    $('#dependencia').addClass("show");
                    $('#marca').removeClass("show");
                    $('#marca').addClass("hidden");
                    $('#add-cor').removeClass("show");
                    $('#add-cor').addClass("hidden");
                } else {
                    if ($('#comite-novedad_id').val() == '34') {
                        $('#add-cor').removeClass("hidden");
                        $('#add-cor').addClass("show");
                        $('#marca').removeClass("show");
                        $('#marca').addClass("hidden");
                        $('#dependencia').removeClass("show");
                        $('#dependencia').addClass("hidden");
                    } else {
                        $('#dependencia').removeClass("show");
                        $('#marca').removeClass("show");
                        $('#add-cor').removeClass("show");
                        $('#marca').addClass("hidden");
                        $('#dependencia').addClass("hidden");
                        $('#add-cor').addClass("hidden");
                    }
                }
            }
        });
    }
    if ($('#marca-chk').length > 0) {
        $('#marca-chk').on('click', function() {
            if ($('#marca-chk').is(':checked')) {
                $('#div-marca').removeClass("hidden");
                $('#div-marca').addClass("show");
            } else {
                $('#div-marca').removeClass("show");
                $('#div-marca').addClass("hidden");
            }
        });
    }
    if ($('#otros-chk').length > 0) {
        $('#otros-chk').on('click', function() {
            if ($('#otros-chk').is(':checked')) {
                $('#dependencia').prop('disabled', 'disabled');
                $('#evento-cantidad_apoyo').prop('disabled', 'disabled');
                $('#evento-otros').prop('readonly', null);
                $('#evento-cantidad_apoyo_otros').prop('readonly', null);
            } else {
                $('#dependencia').prop('disabled', null);
                $('#evento-cantidad_apoyo').prop('disabled', null);
                $('#evento-otros').prop('readonly', 'readonly');
                $('#evento-cantidad_apoyo_otros').prop('readonly', 'readonly');
            }
        });
    }
    /******************* Fin Pendiente ************************************/
    if ($('#distrito-chk').length > 0) {
        $('#distrito-chk').on('click', function() {
            if ($('#distrito-chk').is(':checked')) {
                $('#div-distrito').removeClass("hidden");
                $('#div-distrito').addClass("show");
            } else {
                $('#div-distrito').removeClass("show");
                $('#div-distrito').addClass("hidden");
            }
        });
    }
    if ($('#todas').length > 0) {
        $('#todas').on('click', function() {
            if ($('#todas').is(':checked')) {
                $('#dependencias').removeClass("show");
                $('#dependencias').addClass("hidden");
                $('#btn-add').removeClass("show");
                $('#btn-add').addClass("hidden");
            } else {
                $('#dependencias').removeClass("hidden");
                $('#dependencias').addClass("show");
                $('#btn-add').removeClass("hidden");
                $('#btn-add').addClass("show");
            }
        });
    }
    if (typeof index !== 'undefined') {
        if (index == 1) {
            if (($('#capacitacion-novedad_id').val() != '23' || $('#capacitacion-novedad_id').val() != '24') && $('#capacitacion-novedad_id').val() != '') {
                var opciones = [];
                for (i = 0; i < len; i++) {
                    opciones.push('<option value="' + dependencias[i]['codigo'] + '">' + dependencias[i]['nombre'] + '</option>');
                }
                $('#dependencias').prepend('<div class="col-md-12"><div class="col-md-6"><label>Dependencia</label><select class="form-control" name="sel-dep-' + index + '"  id="sel-dep-' + index + '"></select></div><div class="col-md-6"><label># Personas</label><input type="text" class="form-control" name="txt-cant-' + index + '" id="txt-cant-' + index + '"/></div></div>');
                $('#sel-dep-' + index).append(opciones);
                if ($('#sel-dep-' + index).length > 0) {
                    $('#sel-dep-' + index).select2();
                }
                $('#cantidad').val(index);
                index++;
            }
        }
    }
    if (typeof index_material !== 'undefined') {
        $("input").focus(function() {
            total_recuperado = 0;
            for (i = 1; i < index_material; i++) {
                total_recuperado = total_recuperado + ($('#txt-cantidad-' + i).val() * $('#txt-valor-' + i).val());
            }
            //alert(total_recuperado);
            //escribir total
            $('#total').val(total_recuperado);
        });
    }
    if (typeof index_merma !== 'undefined') {
        if (index_merma == 1) {
            var opciones = [];
            for (i = 0; i < len; i++) {
                opciones.push('<option value="' + dependencias[i]['codigo'] + '">' + dependencias[i]['nombre'] + '</option>');
            }
            $('#dependencias').prepend('<div class="col-md-12"><div class="col-md-12"><label>Dependencia</label><select class="form-control" name="sel-dep-' + index_merma + '"  id="sel-dep-' + index_merma + '"></select></div></div>');
            $('#sel-dep-' + index_merma).append(opciones);
            if ($('#sel-dep-' + index_merma).length > 0) {
                $('#sel-dep-' + index_merma).select2();
            }
            $('#cantidad-dep').val(index_merma);
            index_merma++;
        }
    }
    if (typeof index_material !== 'undefined') {
        if (index_material == 1) {
            $('#mermas').prepend('<div class="col-md-12"><div class="col-md-4"><label>Producto</label><input class="form-control" name="txt-material-' + index_material + '"  id="txt-material-' + index_material + '"/></div><div class="col-md-4"><label>Cantidad</label><input class="form-control" value="0" name="txt-cantidad-' + index_material + '"  id="txt-cantidad-' + index_material + '"/></div><div class="col-md-4"><label>Valor</label><input value="0" class="form-control sumar" name="txt-valor-' + index_material + '"  id="txt-valor-' + index_material + '"/></div></div>');
            $('#cantidad-mat').val(index_material);
            index_material++;
        }
    }
    if ($('#btn-add-mat-mer').length > 0) {
        $('#btn-add-mat-mer').on('click', function() {
            $('#mermas').prepend('<div class="col-md-12"><div class="col-md-4"><label>Producto</label><input class="form-control" name="txt-material-' + index_material + '"  id="txt-material-' + index_material + '"/></div><div class="col-md-4"><label>Cantidad</label><input class="form-control" value="0" name="txt-cantidad-' + index_material + '"  id="txt-cantidad-' + index_material + '"/></div><div class="col-md-4"><label>Valor</label><input value="0" class="form-control sumar" name="txt-valor-' + index_material + '"  id="txt-valor-' + index_material + '"/></div></div>');
            $('#cantidad-mat').val(index_material);
            index_material++;
            total_recuperado = 0;
            for (i = 1; i < index_material; i++) {
                total_recuperado = total_recuperado + ($('#txt-cantidad-' + i).val() * $('#txt-valor-' + i).val());
            }
            //alert(total_recuperado);
            //escribir total
            $('#total').val(total_recuperado);
        });
    }
    /************ Adicionar Cuadro Area Material*******************/
    if ($('#btn-add-area').length > 0) {
        $('#btn-add-area').on('click', function() {
            var opciones = [];
            opciones.push('<option value="0"></option>');
            for (i = 0; i < len_areas; i++) {
                opciones.push('<option value="' + areas[i]['codigo'] + '">' + areas[i]['nombre'] + '</option>');
            }
            $('#areas').append('<p>&nbsp;</p><div class="col-md-6"><label class="control-label" for="merma-area_dependencia_id">Area</label><select placeholder="Area" class="form-control" name="sel-area-' + index_area + '"  id="sel-area-' + index_area + '"></select></div><div class="col-md-6"><label class="control-label" for="merma-zona_dependencia_id">Zona</label><select class="form-control" id="child-' + index_area + '" class="depdrop" ></select></div><p>&nbsp;</p><div id="mermas-' + index_area + '" class="form-group"></div><div class="col-md-12"><div class="col-md-4"><label>Producto</label><input class="form-control" name="txt-material-' + index_material + '"  id="txt-material-' + index_material + '"/></div><div class="col-md-4"><label>Cantidad</label><input class="form-control" value="0" name="txt-cantidad-' + index_material + '"  id="txt-cantidad-' + index_material + '"/></div><div class="col-md-4"><label>Valor</label><input value="0" class="form-control sumar" name="txt-valor-' + index_material + '"  id="txt-valor-' + index_material + '"/></div></div><div class="col-md-12"><p>&nbsp;</p><button  onclick="addMaterial();" type="button"  class="btn btn-default btn-primary pull-right" aria-label="Left Align"><span class="glyphicon glyphicon-plus" aria-hidden="true"> Producto</span></button></div>');
            $('#sel-area-' + index_area).append(opciones);
            if ($('#sel-area-' + index_area).length > 0) {
                $('#sel-area-' + index_area).select2();
            }
            if ($('#child-' + index_area).length > 0) {
                $('#child-' + index_area).select2();
            }
            index_area++;
            index_material++;
            if ($('#child-1').length > 0) {
                for (i = 1; i < index_area; i++) {
                    $("#child-" + i).depdrop({
                        depends: ['sel-area-' + i],
                        url: '/sgs/web/zona-dependencia/listado'
                    });
                }
            }
        });
    }
    if ($('#child-1').length > 0) {
        for (i = 1; i < index_area; i++) {
            $("#child-" + i).depdrop({
                depends: ['sel-area-' + i],
                url: '/exito/web/zona-dependencia/listado'
            });
        }
    }
    /**************************************************************/
    if ($('#btn-add-dep-mer').length > 0) {
        $('#btn-add-dep-mer').on('click', function() {
            var opciones = [];
            for (i = 0; i < len; i++) {
                opciones.push('<option value="' + dependencias[i]['codigo'] + '">' + dependencias[i]['nombre'] + '</option>');
            }
            $('#dependencias').prepend('<div class="col-md-12"><div class="col-md-12"><label>Dependencia</label><select class="form-control" name="sel-dep-' + index_merma + '"  id="sel-dep-' + index_merma + '"></select></div></div>');
            $('#sel-dep-' + index_merma).append(opciones);
            if ($('#sel-dep-' + index_merma).length > 0) {
                $('#sel-dep-' + index_merma).select2();
            }
            $('#cantidad-dep').val(index_merma);
            index_merma++;
        });
    }
    //Adicionar Producto pedido normal
    if ($('#btn-add-producto').length > 0) {
	    $('#btn-add-producto').on('click', function() {
	    	len_productos = productos.length;
	        var opciones1 = [];
	        var proveedores = [];
	        var temp = '';
	        var prov = '';
	        var precio = 0;
	        for (i = 0; i < len_productos; i++) {
	            temp = temp + '<option value="' + productos[i]['codigo'] + '">' + productos[i]['nombre'] + '</option>';
	            //console.log(productos[i]['nombre'])
	            if (i == 0) {
	                prov = productos[i]['proveedor'];
	                precio = productos[i]['precio'];
	            }
	        }
	        //   console.log(opciones);
	        $('#lastRow').append('<tr>'+
	            					 '<td>'+
	            					 	'<label id="lbl-' + index_productos + '">' + prov + '</label>'+
	            					 '</td>'+
	            					 '<td>'+
	            					 	'<select onchange="proveedor(this,' + index_productos + ');" name="sel-produ-' + index_productos + '" id="sel-produ-' + index_productos + '" >' +
	            					 		 temp + 
	            					 	'</select>'+
	            					 	'<input name="price-' + index_productos + '" id="price-' + index_productos + '" type="hidden" value="'+precio+'" class="form-control"/>'+
	            					 '</td>'+
	            					 '<td>'+
	            					 	'<input name="txt-cant-' + index_productos + '" id="txt-cant-' + index_productos + '" type="text"  class="form-control"/>'+
	            					 '</td>'+
	            					 '<td>'+
	            					 	'<input name="txt-comentario-' + index_productos + '" id="txt-comentario-' + index_productos + '" type="text"  class="form-control"/>'+
	            					 '</td>'+
	        					 '</tr>');
	        if ($('#sel-produ-' + index_productos).length > 0) {
	            $('#sel-produ-' + index_productos).select2({
	                width: '95%'
	            });
	        }
	        $('#cantidad-productos').val(index_productos);
	        index_productos++;
	    });
	}
    
    //Adicionar fila a modelo prefactura
    if ($('#btn-add-fila-prefactura').length > 0) {
        $('#btn-add-fila-prefactura').on('click', function() {
            var temp = '<option value="1"></option>';
            var index_precio = index_servicio - 1;
            for (i = 0; i < len_servicios; i++) {
                temp = temp + '<option value="' + servicios[i]['codigo'] + '">' + servicios[i]['nombre'] + '</option>';
            }
            $('#lastRow').append('<tr><td></td><td style="text-align: center;"><input type="hidden" id="txt-precio-' + index_servicio + '" name="txt-precio-' + index_servicio + '"/><label id="label-precio-' + index_servicio + '">0</label></td><td><input type="hidden" name="txt-id-' + index_servicio + '" id="txt-id-' + index_servicio + '"/><select  name="sel-servicio-' + index_servicio + '" id="sel-servicio-' + index_servicio + '" >' + temp + '</select></td><td><select onchange="cargarValoresServicio(this,' + index_servicio + ');" class="form-control" name="child-' + index_servicio + '" id="child-' + index_servicio + '" class="depdrop" ></select></td><td><input type="number" class="form-control" value="1" name="txt-cant-' + index_servicio + '" id="txt-cant-' + index_servicio + '" type="text"  class="form-control"/></td><td><select onchange="calculaFtes(this,' + index_servicio + ');" name="sel-jornada-' + index_servicio + '" id="sel-jornada-' + index_servicio + '" >' + jornada + '</select></td><td><select onchange="finalServicio(this,' + index_servicio + ');" name="sel-desde-' + index_servicio + '" id="sel-desde-' + index_servicio + '" >' + sel_desde + '</select></td><td style="text-align:center;" ><label id="label-hasta-' + index_servicio + '" >00:00</label><input type="hidden" id="txt-hasta-' + index_servicio + '" name="txt-hasta-' + index_servicio + '"/></td><td><input type="checkbox" onclick="totalDias(this,' + index_servicio + ');" name="check-lunes-' + index_servicio + '" id="check-lunes-' + index_servicio + '" /></td><td><input type="checkbox" onclick="totalDias(this,' + index_servicio + ');" name="check-martes-' + index_servicio + '" id="check-martes-' + index_servicio + '" /></td><td><input type="checkbox" onclick="totalDias(this,' + index_servicio + ');" name="check-miercoles-' + index_servicio + '" id="check-miercoles-' + index_servicio + '" /></td><td><input onclick="totalDias(this,' + index_servicio + ');" type="checkbox" name="check-jueves-' + index_servicio + '" id="check-jueves-' + index_servicio + '" /></td><td><input type="checkbox" onclick="totalDias(this,' + index_servicio + ');" name="check-viernes-' + index_servicio + '" id="check-viernes-' + index_servicio + '" /></td><td><input type="checkbox" onclick="totalDias(this,' + index_servicio + ');" name="check-sabado-' + index_servicio + '" id="check-sabado-' + index_servicio + '" /></td><td><input type="checkbox" onclick="totalDias(this,' + index_servicio + ');" name="check-domingo-' + index_servicio + '" id="check-domingo-' + index_servicio + '" /></td><td><input type="checkbox" onclick="totalDias(this,' + index_servicio + ');" name="check-festivo-' + index_servicio + '" id="check-festivo-' + index_servicio + '" /></td><td><input class="form-control" value="100" name="txt-porcentaje-' + index_servicio + '" id="txt-porcentaje-' + index_servicio + '" /></td><td style="text-align:center;"><input type="hidden" id="txt-ftes-' + index_servicio + '" name="txt-ftes-' + index_servicio + '"/><label id="label-ftes-' + index_servicio + '" >0</label></td><td style="text-align:center;" ><input type="hidden" id="txt-dias-' + index_servicio + '" name="txt-dias-' + index_servicio + '"/><label id="label-dias-' + index_servicio + '" >0</label></td></tr>');
            if ($('#sel-servicio-' + index_servicio).length > 0) {
                $('#sel-servicio-' + index_servicio).select2({
                    width: '100%'
                });
            }
            if ($('#sel-jornada-' + index_servicio).length > 0) {
                $('#sel-jornada-' + index_servicio).select2({
                    width: '100%'
                });
            }
            if ($('#sel-desde-' + index_servicio).length > 0) {
                $('#sel-desde-' + index_servicio).select2({
                    width: '100%'
                });
            }
            $('#cantidad-filas').val(index_servicio);
            if ($('#child-' + index_servicio).length > 0) {
                $("#child-" + index_servicio).depdrop({
                    depends: ['sel-servicio-' + index_servicio],
                    url: '/exito/web/centro-costo/puestos'
                    //url: '/centro-costo/puestos'
                });
                $('#child-' + index_servicio).select2({
                    width: '100%'
                });
            }
            index_servicio++;
            //alert(index_servicio);
        });
    }
    //////////////////////////////////////
    //Adicionar fila a modelo prefactura
    if ($('#btn-add-fila-prefactura-variable').length > 0) {
        $('#btn-add-fila-prefactura-variable').on('click', function() {
            var temp = '<option value="1"></option>';
            var index_precio = index_servicio - 1;
            for (i = 0; i < len_servicios; i++) {
                temp = temp + '<option value="' + servicios[i]['codigo'] + '">' + servicios[i]['nombre'] + '</option>';
            }
            $('#lastRow').append('<tr><td></td><td><input type="hidden" name="txt-id-' + index_servicio + '" id="txt-id-' + index_servicio + '"/><select  name="sel-servicio-' + index_servicio + '" id="sel-servicio-' + index_servicio + '" >' + temp + '</select></td><td><select onchange="cargarValoresServicio(this,' + index_servicio + ');" class="form-control" name="child-' + index_servicio + '" id="child-' + index_servicio + '" class="depdrop" ></select></td><td><input type="number" class="form-control" value="1" name="txt-cant-' + index_servicio + '" id="txt-cant-' + index_servicio + '" type="text"  class="form-control"/></td><td><select onchange="calculaFtes(this,' + index_servicio + ');" name="sel-jornada-' + index_servicio + '" id="sel-jornada-' + index_servicio + '" >' + jornada + '</select></td><td><input class="form-control" id="txt-total-dias-' + index_servicio + '" name="txt-total-dias-' + index_servicio + '" type="text" value="1"/></td><td><select name="sel-tipo-servicio-' + index_servicio + '" id="sel-tipo-servicio-' + index_servicio + '" >' + tipo_servicio + '</select></td><td><select onchange="finalServicioVariable(this,' + index_servicio + ');" name="sel-desde-' + index_servicio + '" id="sel-desde-' + index_servicio + '" >' + sel_desde + '</select></td><td style="text-align:center;" ><label id="label-hasta-' + index_servicio + '" >00:00</label><input type="hidden" id="txt-hasta-' + index_servicio + '" name="txt-hasta-' + index_servicio + '"/></td><td><input class="form-control" value="100" name="txt-porcentaje-' + index_servicio + '" id="txt-porcentaje-' + index_servicio + '" /></td><td style="text-align:center;"><input type="hidden" id="txt-ftes-' + index_servicio + '" name="txt-ftes-' + index_servicio + '"/><label id="label-ftes-' + index_servicio + '" >0</label></td><td style="text-align:center;" ><input type="hidden" id="txt-dias-' + index_servicio + '" name="txt-dias-' + index_servicio + '"/><label id="label-dias-' + index_servicio + '" >0</label></td><td style="text-align: center;"><input type="hidden" id="txt-precio-' + index_servicio + '" name="txt-precio-' + index_servicio + '"/><label id="label-precio-' + index_servicio + '">0</label></td></tr>');
            if ($('#sel-servicio-' + index_servicio).length > 0) {
                $('#sel-servicio-' + index_servicio).select2({
                    width: '100%'
                });
            }
            if ($('#sel-jornada-' + index_servicio).length > 0) {
                $('#sel-jornada-' + index_servicio).select2({
                    width: '100%'
                });
            }
            if ($('#sel-tipo-servicio-' + index_servicio).length > 0) {
                $('#sel-tipo-servicio-' + index_servicio).select2({
                    width: '100%'
                });
            }
            if ($('#sel-desde-' + index_servicio).length > 0) {
                $('#sel-desde-' + index_servicio).select2({
                    width: '100%'
                });
            }
            $('#cantidad-filas').val(index_servicio);
            if ($('#child-' + index_servicio).length > 0) {
                $("#child-" + index_servicio).depdrop({
                    depends: ['sel-servicio-' + index_servicio],
                    //url: '/exito/web/centro-costo/puestos'
                    url: '/centro-costo/puestos'
                });
                $('#child-' + index_servicio).select2({
                    width: '100%'
                });
            }
            index_servicio++;
            //alert(index_servicio);
        });
    }
    if ($('#btn-add').length > 0) {
        $('#btn-add').on('click', function() {
            var opciones = [];
            for (i = 0; i < len; i++) {
                opciones.push('<option value="' + dependencias[i]['codigo'] + '">' + dependencias[i]['nombre'] + '</option>');
            }
            $('#dependencias').prepend('<div class="col-md-12"><div class="col-md-6"><label>Dependencia</label><select class="form-control" name="sel-dep-' + index + '"  id="sel-dep-' + index + '"></select></div><div class="col-md-6"><label># Personas</label><input type="text" class="form-control" name="txt-cant-' + index + '" id="txt-cant-' + index + '"/></div></div>');
            $('#sel-dep-' + index).append(opciones);
            if ($('#sel-dep-' + index).length > 0) {
                $('#sel-dep-' + index).select2();
            }
            $('#cantidad').val(index);
            index++;
        });
    }
    if ($('#btn-add-cor').length > 0) {
        $('#btn-add-cor').on('click', function() {
            var opciones = [];
            for (i = 0; i < len_cor; i++) {
                opciones.push('<option value="' + cordinadores[i]['usuario'] + '">' + cordinadores[i]['nombre'] + '</option>');
            }
            $('#cordinadores').prepend('<div class="col-md-12"><div class="col-md-6"><label>Cordinador</label><select class="form-control" name="sel-cor-' + index_cor + '"  id="sel-cor-' + index_cor + '"></select></div></div>');
            $('#sel-cor-' + index_cor).append(opciones);
            if ($('#sel-cor-' + index_cor).length > 0) {
                $('#sel-cor-' + index_cor).select2();
            }
            $('#cantidad-cor').val(index_cor);
            index_cor++;
        });
    }
    var table = $('.my-data').DataTable({
        "columnDefs": [{
            "className": "dt-center",
            "targets": "_all"
        }],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf'],
        // "order": [[0,"desc"]],
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
    table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container()));
    var table2 = $('.my-data2').DataTable({
        "columnDefs": [{
            "className": "dt-center",
            "targets": "_all"
        }],
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf'],
        // "order": [[0,"desc"]],
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
    table2.buttons().container().appendTo($('.col-sm-6:eq(0)', table2.table().container()));
    //Adicionar Producto pedido especial
    if ($('#btn-add-producto-especial').length > 0) {
        $('#btn-add-producto-especial').on('click', function() {
            len_productos = productos.length;
            var opciones1 = [];
            var temp = '';
            var precio = 0;
            for (i = 0; i < len_productos; i++) {
                temp = temp + '<option value="' + productos[i]['codigo'] + '" cod_material="'+productos[i]['cod_material']+'">' + productos[i]['nombre'] + '</option>';
                precio = productos[i]['precio'];
            }
            //   console.log(opciones);
            //$('#lastRowEspeciales').append('</td><td></td><td></td><td><input name="txt-comentario-' + index_productos + '" id="txt-comentario-'+ index_productos +'" type="text"  class="form-control"/></td><td><input name="file-cot-' + index_productos + '" id="file-cot-'+ index_productos +'" type="file"/></td></tr>');
            $('#productos').append('<div class="col-md-12">'+
                '<div class="col-md-12">'+
                    '<select class="productos form-control" onchange="manejoEspecial(this,' + index_productos + ');" name="sel-produ-' + index_productos + '" id="sel-produ-' + index_productos + '" index="' + index_productos + '">' + 
                    temp + 
                    '</select>'+

                    '<input name="price-' + index_productos + '" id="price-' + index_productos + '" type="hidden" value="'+precio+'" class="form-control"/>'+

                '</div>'+
                '<p>&nbsp;</p>'+
                '<div class="col-md-12">'+
                    '<div class="col-md-9">'+
                        '<input placeholder="Descripción del producto" name="txt-prod-' + index_productos + '" id="txt-prod-' + index_productos + '" type="text"  class="form-control" required />'+
                    '</div>'+
                    '<div class="col-md-3">'+
                        '<input name="txt-cant-' + index_productos + '" id="txt-cant-' + index_productos + '" type="text"  value="1" placeholder="Cantidad" class="form-control"/>'+
                    '</div>'+
                '</div>'+
                '<p>&nbsp;</p>'+
                '<div class="col-md-12">'+
                    '<div class="col-md-4 form-inline">'+
                        '$ <input name="txt-precio-' + index_productos + '" placeholder="Precio Sugerido" id="txt-precio-' + index_productos + '" type="text"  class="form-control" required /> COL'+
                    '</div>'+
                    '<div class="col-md-8">'+
                        '<input name="txt-proveedor-' + index_productos + '" placeholder="Proveedor Sugerido" id="txt-proveedor-' + index_productos + '" type="text"  class="form-control" required/>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<p>&nbsp;</p>'+
            '<div class="col-md-12"></div><p>&nbsp;</p>');
            

            if ($('#sel-produ-' + index_productos).length > 0) {
                $('#sel-produ-' + index_productos).select2({
                    width: '80%'
                });
            }
            $('#cantidad-productos').val(index_productos);
            index_productos++;
            $("select[name*=sel-produ]").each(function(){
                manejoEspecial(this, $(this).attr('index'));
            });
        });
    }
});