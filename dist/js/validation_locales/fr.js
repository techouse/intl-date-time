(window.wpJsonpIntlDateTime=window.wpJsonpIntlDateTime||[]).push([[14],{18:function(e,t,n){e.exports=function(){"use strict";var e,t={name:"fr",messages:{_default:function(e){return"Le champ "+e+" n'est pas valide"},after:function(e,t){return"Le champ "+e+" doit être postérieur à "+t[0]},alpha:function(e){return"Le champ "+e+" ne peut contenir que des lettres"},alpha_dash:function(e){return"Le champ "+e+" ne peut contenir que des caractères alpha-numériques, tirets ou soulignés"},alpha_num:function(e){return"Le champ "+e+" ne peut contenir que des caractères alpha-numériques"},alpha_spaces:function(e){return"Le champ "+e+" ne peut contenir que des lettres ou des espaces"},before:function(e,t){return"Le champ "+e+" doit être antérieur à "+t[0]},between:function(e,t){return"Le champ "+e+" doit être compris entre "+t[0]+" et "+t[1]},confirmed:function(e,t){return"Le champ "+e+" ne correspond pas à "+t[0]},credit_card:function(e){return"Le champ "+e+" est invalide"},date_between:function(e,t){return"Le champ "+e+" doit être situé entre "+t[0]+" et "+t[1]},date_format:function(e,t){return"Le champ "+e+" doit être au format "+t[0]},decimal:function(e,t){void 0===t&&(t=[]);var n=t[0];return void 0===n&&(n="*"),"Le champ "+e+" doit être un nombre et peut contenir "+("*"===n?"des":n)+" décimales"},digits:function(e,t){return"Le champ "+e+" doit être un nombre entier de "+t[0]+" chiffres"},dimensions:function(e,t){return"Le champ "+e+" doit avoir une taille de "+t[0]+" pixels par "+t[1]+" pixels"},email:function(e){return"Le champ "+e+" doit être une adresse e-mail valide"},excluded:function(e){return"Le champ "+e+" doit être une valeur valide"},ext:function(e){return"Le champ "+e+" doit être un fichier valide"},image:function(e){return"Le champ "+e+" doit être une image"},included:function(e){return"Le champ "+e+" doit être une valeur valide"},integer:function(e){return"Le champ "+e+" doit être un entier"},ip:function(e){return"Le champ "+e+" doit être une adresse IP"},length:function(e,t){var n=t[0],r=t[1];return r?"Le champ "+e+" doit contenir entre "+n+" et "+r+" caractères":"Le champ "+e+" doit contenir "+n+" caractères"},max:function(e,t){return"Le champ "+e+" ne peut pas contenir plus de "+t[0]+" caractères"},max_value:function(e,t){return"Le champ "+e+" doit avoir une valeur de "+t[0]+" ou moins"},mimes:function(e){return"Le champ "+e+" doit avoir un type MIME valide"},min:function(e,t){return"Le champ "+e+" doit contenir au minimum "+t[0]+" caractères"},min_value:function(e,t){return"Le champ "+e+" doit avoir une valeur de "+t[0]+" ou plus"},numeric:function(e){return"Le champ "+e+" ne peut contenir que des chiffres"},regex:function(e){return"Le champ "+e+" est invalide"},required:function(e){return"Le champ "+e+" est obligatoire"},required_if:function(e,t){return"Le champ "+e+" est obligatoire lorsque "+t[0]+" possède cette valeur"},size:function(e,t){return"Le champ "+e+" doit avoir un poids inférieur à "+function(e){var t=1024,n=0==(e=Number(e)*t)?0:Math.floor(Math.log(e)/Math.log(t));return 1*(e/Math.pow(t,n)).toFixed(2)+" "+["Byte","KB","MB","GB","TB","PB","EB","ZB","YB"][n]}(t[0])},url:function(e){return"Le champ "+e+" n'est pas une URL valide"}},attributes:{}};return"undefined"!=typeof VeeValidate&&VeeValidate.Validator.localize(((e={})[t.name]=t,e)),t}()}}]);