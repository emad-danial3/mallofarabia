 <!-- mobile fix menu start -->
    <div class="mobile-menu d-md-none d-block mobile-cart">
        <ul>
            <li class="active">
                <a href="/">
                    <i class="iconly-Home icli"></i>
                    <span>Home</span>
                </a>
            </li>

            <li class="mobile-category">
                <a href="{{url('products')}}">
                    <i class="iconly-Category icli js-link"></i>
                    <span>{{trans('auth.attributes.products',[],session()->get('locale'))}}</span>
                </a>
            </li>



            <li>
                <a href="{{url('/wishlist')}}" class="notifi-wishlist">
                    <i class="iconly-Heart icli"></i>
                    <span>{{trans('website.wishList',[],session()->get('locale'))}}</span>
                </a>
            </li>

            <li>
                <a href="{{url('/getCart')}}">
                    <i class="iconly-Bag-2 icli fly-cate"></i>
                    <span>{{trans('website.Cart',[],session()->get('locale'))}}</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- mobile fix menu end -->
