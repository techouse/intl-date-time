(window.wpJsonpIntlDateTime=window.wpJsonpIntlDateTime||[]).push([[9],{13:function(e,n,r){e.exports=function(){"use strict";var e,n={name:"es",messages:{_default:function(e){return"El campo "+e+" no es válido"},after:function(e,n){var r=n[0];return"El campo "+e+" debe ser posterior "+(n[1]?"o igual ":"")+"a "+r},alpha:function(e){return"El campo "+e+" solo debe contener letras"},alpha_dash:function(e){return"El campo "+e+" solo debe contener letras, números y guiones"},alpha_num:function(e){return"El campo "+e+" solo debe contener letras y números"},alpha_spaces:function(e){return"El campo "+e+" solo debe contener letras y espacios"},before:function(e,n){var r=n[0];return"El campo "+e+" debe ser anterior "+(n[1]?"o igual ":"")+"a "+r},between:function(e,n){return"El campo "+e+" debe estar entre "+n[0]+" y "+n[1]},confirmed:function(e){return"El campo "+e+" no coincide"},credit_card:function(e){return"El campo "+e+" es inválido"},date_between:function(e,n){return"El campo "+e+" debe estar entre "+n[0]+" y "+n[1]},date_format:function(e,n){return"El campo "+e+" debe tener un formato "+n[0]},decimal:function(e,n){void 0===n&&(n=[]);var r=n[0];return void 0===r&&(r="*"),"El campo "+e+" debe ser numérico y contener"+(r&&"*"!==r?" "+r:"")+" puntos decimales"},digits:function(e,n){return"El campo "+e+" debe ser numérico y contener exactamente "+n[0]+" dígitos"},dimensions:function(e,n){return"El campo "+e+" debe ser de "+n[0]+" píxeles por "+n[1]+" píxeles"},email:function(e){return"El campo "+e+" debe ser un correo electrónico válido"},excluded:function(e){return"El campo "+e+" debe ser un valor válido"},ext:function(e){return"El campo "+e+" debe ser un archivo válido"},image:function(e){return"El campo "+e+" debe ser una imagen"},included:function(e){return"El campo "+e+" debe ser un valor válido"},integer:function(e){return"El campo "+e+" debe ser un entero"},ip:function(e){return"El campo "+e+" debe ser una dirección ip válida"},length:function(e,n){var r=n[0],o=n[1];return o?"El largo del campo "+e+" debe estar entre "+r+" y "+o:"El largo del campo "+e+" debe ser "+r},max:function(e,n){return"El campo "+e+" no debe ser mayor a "+n[0]+" caracteres"},max_value:function(e,n){return"El campo "+e+" debe de ser "+n[0]+" o menor"},mimes:function(e){return"El campo "+e+" debe ser un tipo de archivo válido"},min:function(e,n){return"El campo "+e+" debe tener al menos "+n[0]+" caracteres"},min_value:function(e,n){return"El campo "+e+" debe ser "+n[0]+" o superior"},numeric:function(e){return"El campo "+e+" debe contener solo caracteres numéricos"},regex:function(e){return"El formato del campo "+e+" no es válido"},required:function(e){return"El campo "+e+" es obligatorio"},size:function(e,n){return"El campo "+e+" debe ser menor a "+function(e){var n=1024,r=0==(e=Number(e)*n)?0:Math.floor(Math.log(e)/Math.log(n));return 1*(e/Math.pow(n,r)).toFixed(2)+" "+["Byte","KB","MB","GB","TB","PB","EB","ZB","YB"][r]}(n[0])},url:function(e){return"El campo "+e+" no es una URL válida"}},attributes:{}};return"undefined"!=typeof VeeValidate&&VeeValidate.Validator.localize(((e={})[n.name]=n,e)),n}()}}]);