// class rupiah untuk format rupiah 
$(document).on("keyup", ".rupiah", function(){
    $(this).val(formatRupiah(this.value, 'Rp. '))
})

// number only 
$(".number").inputFilter(function(value) {
    return /^\d*$/.test(value);    // Allow digits only, using a RegExp
});