document.body.style.setProperty("--theme-color", '#8563a5');
var getLange    = localStorage.getItem('website_lang');
if(getLange=='ar'){
    $("html").attr("dir", "rtl");
    $("body").removeClass("ltr");
    $("body").addClass("rtl");
    $("#rtl-link").attr("href", "../assets/css/vendors/bootstrap.rtl.css");
     localStorage.setItem("website_lang", 'ar');
}else{
    $("html").attr("dir", "ltr");
    $("body").removeClass("rtl");
    $("body").addClass("ltr");
    $("#rtl-link").attr("href", "../assets/css/vendors/bootstrap.css");
    localStorage.setItem("website_lang", 'en');
}
$(document).ready(function () {
    // old cart in localstorage

    var userCart = localStorage.getItem('user_cart');
    if (!userCart || userCart == null || userCart == '' || userCart.length == 0) {
        $('#herderCardCount').html('0')
        $('#herderCardTotalCount').html(0)
        $('#herderUpToTotalCount').html(0)
    }
    else {
        const allProductsArray = JSON.parse(userCart);
        const cartLength       = allProductsArray.length;
        var subtotal           = 0;
        var shipping           = 0;
        var total_cart         = 0;
        for (let ii = 0; ii < cartLength; ii++) {
            var proObjff      = allProductsArray[ii];
            proObjff['total'] = (Number(proObjff['price']) * parseInt(proObjff['quantity']));
            subtotal          = (Number(subtotal) + Number(proObjff['total']));
            total_cart        = (Number(total_cart) + Number(proObjff['total']));
        }
        if (subtotal > 0 && subtotal < 250) {
            shipping   = 50;
            total_cart = subtotal + shipping;
        }
        $('#herderCardCount').html(cartLength)
        $('#herderCardTotalCount').html(total_cart +' LE')
        let upto=(total_cart - (total_cart * .3))
        $('#herderUpToTotalCount').html(upto +' LE')
    }
        var userWishlist = localStorage.getItem('user_wishlist');
            let arrLength    = JSON.parse(userWishlist);
            if (!userWishlist || userWishlist == null || userWishlist == '' || userWishlist.length == 0 || arrLength.length == 0) {
                $('#herderWishlistCount').html(0)
            }
            else {
                const  allWishlistProductsArray = JSON.parse(userWishlist);
                const cartwishlistLength = allWishlistProductsArray.length;
               $('#herderWishlistCount').html(cartwishlistLength)
            }
});
