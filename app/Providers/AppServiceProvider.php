<?php

namespace App\Providers;


use App\Http\Repositories\AreaRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\CategoriesRepository;
use App\Http\Repositories\CityRepository;
use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\CountryRepository;
use App\Http\Repositories\ForgotPasswordRepository;
use App\Http\Repositories\GeneralRepository;
use App\Http\Repositories\IAreaRepository;
use App\Http\Repositories\ICartRepository;
use App\Http\Repositories\ICategoriesRepository;
use App\Http\Repositories\ICityRepository;
use App\Http\Repositories\ICompanyRepository;
use App\Http\Repositories\ICountryRepository;
use App\Http\Repositories\IForgotPasswordRepository;
use App\Http\Repositories\IGeneralRepository;
use App\Http\Repositories\INotificationRepository;
use App\Http\Repositories\IOracleProductRepository;
use App\Http\Repositories\IOracleInvoiceRepository;
use App\Http\Repositories\OracleInvoiceRepository;
use App\Http\Repositories\IOrderLinesRepository;
use App\Http\Repositories\IOrderRepository;
use App\Http\Repositories\IPaymentLogRepository;
use App\Http\Repositories\IProductCategoriesRepository;
use App\Http\Repositories\IProductRepository;
use App\Http\Repositories\IUserNotificationRepository;
use App\Http\Repositories\IUserRepository;
use App\Http\Repositories\NotificationRepository;
use App\Http\Repositories\OracleProductRepository;
use App\Http\Repositories\OrderLinesRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\PaymentLogRepository;
use App\Http\Repositories\ProductCategoriesRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\PurchaseInvoiceLinesRepository;
use App\Http\Repositories\PurchaseInvoiceRepository;
use App\Http\Repositories\IPurchaseInvoiceRepository;
use App\Http\Repositories\IPurchaseInvoicesLineRepository;
use App\Http\Repositories\UserNotificationRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartRepository::class, ICartRepository::class);
        $this->app->bind(ForgotPasswordRepository::class, IForgotPasswordRepository::class);
        $this->app->bind(OrderLinesRepository::class, IOrderLinesRepository::class);
        $this->app->bind(OrderRepository::class, IOrderRepository::class);
        $this->app->bind(PurchaseInvoiceRepository::class, IPurchaseInvoiceRepository::class);
        $this->app->bind(PurchaseInvoiceLinesRepository::class, IPurchaseInvoicesLineRepository::class);
        $this->app->bind(PaymentLogRepository::class, IPaymentLogRepository::class);
        $this->app->bind(ProductRepository::class, IProductRepository::class);
        $this->app->bind(UserRepository::class, IUserRepository::class);
        $this->app->bind(GeneralRepository::class, IGeneralRepository::class);
        $this->app->bind(UserNotificationRepository::class, IUserNotificationRepository::class);
        $this->app->bind(ProductCategoriesRepository::class, IProductCategoriesRepository::class);
        $this->app->bind(CategoriesRepository::class, ICategoriesRepository::class);

        $this->app->bind(AreaRepository::class, IAreaRepository::class);
        $this->app->bind(CountryRepository::class, ICountryRepository::class);
        $this->app->bind(CityRepository::class, ICityRepository::class);
        $this->app->bind(CompanyRepository::class, ICompanyRepository::class);
        $this->app->bind(NotificationRepository::class, INotificationRepository::class);
        $this->app->bind(OracleProductRepository::class, IOracleProductRepository::class);
        $this->app->bind(OracleInvoiceRepository::class, IOracleInvoiceRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       /* DB::listen(function ($query) {
            logger(Str::replaceArray('?',$query->bindings,$query->sql));
        });*/
         if (env('APP_ENV') !== 'local') { //so you can work on it locally
            URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
    }
}
