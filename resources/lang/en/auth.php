<?php

return [

    'accepted' => 'The :attribute must be accepted.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file' => 'The :attribute must be greater than or equal :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
    'uuid' => 'The :attribute must be a valid UUID.',

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],


    'attributes' => [
        'please_write_in_english'=>"Please Write In English Format Only",
        'login'=>'Login',
        'name'                  => 'Name',
        'ar_name'               =>'Arabic Name',
        'en_name'               =>'English Name',
        'username'              => 'UserName',
        'email'                 => 'Email',
        'first_name'            => 'First Name',
        'last_name'             => 'Last Name',
        'password'              => 'Password',
        'password_confirmation' => 'Password Confirmation',
        'city'                  => 'City',
        'country'               => 'Country',
        'address'               => 'Address',
        'phone'                 => 'Phone',
        'mobile'                => 'Mobile',
        'age'                   => 'Age',
        'sex'                   => 'Sex' ,
        'gender'                => 'Gender',
        'day'                   =>  'Day',
        'month'                 => 'Month',
        'year'                  => 'Month',
        'hour'                  => 'Hour',
        'minute'                => 'Minute',
        'second'                => 'Minute',
        'content'               => 'Content',
        'description'           => 'Description',
        'ar_description'    =>'Arabic Description',
        'en_description'        =>'English Description',
        'excerpt'               => 'Excerpt',
        'date'                  => 'Date',
        'time'                  => 'Time',
        'available'             => 'Available',
        'size'                  => 'Size',
        'price'                 => 'Price',
        'desc'                  =>  'Desc',
        'title'                 =>  'Title',
        'q'                     => 'Q',
        'link'                  => 'Link',
        'slug'                  => 'Slug',
        'reset'    => 'Reset',
        'sent'     => 'Sent',
        'token'    =>'Token' ,
        'user'     =>'User' ,
        'previous' => 'Previous',
        'next'     => 'Next',
        'register'     => 'Register',
        'newAccount'     => 'Don\'t have an account',
        'main'     => 'Next',
        'HomeMain'=>'Home',
        'products'     => 'Products',
        'product'     => 'Product',
        'orders'     => 'Orders',
        'order'     => 'Order',
        'profile'     => 'Profile',
        'view'=>'View',
        'add'=>'Add',
        'edit'=>'Edit',
        'order_new'=>'new',
        'order_preparing'=>'Preparing Orders',
        'order_delivering'=>'Delivering Orders',
        'order_delivered'=>'Delivered Orders',
        'order_completed'=>'Competed Orders',
        'order_prepared'=>'Prepared Orders',

        'new'=>'new',
        'preparing'=>'Preparing',
        'delivering'=>'Delivering',
        'delivered'=>'Delivered',
        'completed'=>'Competed',
        'prepared'=>'Prepared',
        'appName'=>'DOKANK',
        'stoke'=>'Stoke',
        'category'=>'Category',
        'offers'=>'Offer',
        'brands'=>'Brands',
        'images'=>'Images',
        'submit'=>'Submit',
        'status'=>'Status',
        'control'=>'Control',
        'published'=>'Published',
        'unpublished'=>'UnPublished',
        'delete'=>'Delete',
        'search'=>'Search',
        'discount'=>'Discount',
        'sold_count'=>'Sold Count',
        'rate'=>'Rate',
        'payment_method'=>'Payment Method',
        'online'=>'Online',
        'cash'=>'Cash',
        'order_status'=>'Order Status',
        'vendors'=>'Vendors',
        'vendor'=>'Vendor',
        'total'=>'Total Cost',
        'change'=>'Change',
        'quantity'=>'Quantity',
        'delivery'=>'has Delivery',
        'image'=>'Image',
        'cover'=>'Cover',
        'number'=>'Number',
        'national_id'=>'National Id',
        'area'=>'Area',
        'package'=>'Package',
        'package_name'=>'Package Name',
        'package_price'=>'Package Price',
        'location'=>'Location',
        'currencies'=>'Currencies',
        'logout'=>'Logout',
        'Overview_Description'=>'Overview Description',
        'netting_hub'=>'Netting Hub',
        'go_free'=>'Go Free',
        'go_premium'=>'Go Premium',
        //Rana Tarek
        //welcome
        'read_more'=>'Read more',
        'read_less'=>'Read less',
        'our_value'=>'Our values',
        'our_mission'=>'Our Mission',
        'our_vision'=>'Our Vision',
        //about us
        'what_is_nettinhhub'=>'What is Netting Hub?',
        'home'=>'Home',
        'brochure'     => 'Brochure',
        'earn more'     => 'Earn More',
        'special offers'     => 'Special Offers',
        'about_us'=>'About Us',
        'how_it_work'=>'How It Works',
        'shopping_categories'=>'Shopping Categories',
        'plans'=>'Plans',
        'free'=>'Free',
        'premium'=>'Premium',
        'contact_us'=>'Contact Us',
        //navbar
        'follow_us'=>'Follow Us',
        //footer
        'go_free_30'=>'If you want a 15 day free app trial',
        'our_process'=>'Our Process',
        //how it work
        'AND_BENEFIT_FROM_THE_BELOW'=>'AND BENEFIT FROM THE BELOW',
        'sing_up'=>' Sign Up For Premuim',
        //premuim
        'contact_us_message'=>'Feel free to reach out for any inquiries, and your feedback helps us get better',
        'eamil'=>'Enter Your Email',
        'phone'=>'Enter Your Phone',
        'massage'=>'Enter Your Message',
        'send'=>'Submit',
        //Contact us
        'free_account_plan'=>'FREE ACCOUNT PLAN',
        'sing_up_free'=>' Sign Up For Free',
        'or_go_premium'=>'OR GO PREMIUM',
        //free
        'middle_name'=>'Middle Name',
        'male'=>'Male',
        'female'=>'female',
        'email'=>'Email',
        'birthday'=>'Birthday',
        'address'=>'Address',
        'city'=>'City',
        'select_city_first'=>'Select City First',
        'building_number'=>'Building Number',
        'floor_number'=>'Floor Number',
        'apartment_number'=>'Apartment Number',
        'landmark'=>'Landmark',
        'telephone'=>'Telephone',
        'id_number'=>'ID Number',
        'front_id'=>'Front ID',
        'back_id'=>'Back ID',
        'id_message'=>'Please provide your ID card image in order issue the bank card for receiving commissions',
        'read_contract'=>'Please read and accept Netting Hub contract to submit your account',
        'contact_text'=>'الموافق ساعته وتاريخ االطالع على الملف فيما بين كال من : الطرفين حرر هذا العقد
أوال: شركة أخناتون للتجارة والتوزيع ش.م.م خاضعة ألحكام القانون رقم 951/9199 - الكائن مقرها 9 ش الشركات - عابدين - جمهورية مصر العربية
ويمثلها فى هذا العقد السيد األستاذ / هشام محمود عويس بصفته رئيس مجلس االدارة للشركة و يشار إلية فيما بعد بـ " الطرف أول"
ثانيا: األستاذ / المشترك بحسب البيانات المسجلة بطاقة رقم قومى/ المسجلة والمدرج صورتها على البرنامج الجنسية : مصرى مقيم فى/ العنوان الموضح
بالبرنامج والمسجل ببطاقة الرقم القومى و يشار إلية فيما بعد " الطرف ثانى "
 تمهيد
الطرف األول شركة مساهمه مصرية وغرضها توزيع مستحضرات التجميل ,و التجارة العامة و التوزيع فحى كحل محاهو مسحمو بحه قانونحا ولمحا كحان الطحرف
الثانى - القابل لذلك - يرغب في ان يكون عميل مشترك لدي برنامج نتينج هاب علي شبكة االنترنت ) الموقع االفتراضي ( و أقر الطرف الثاني بقدرتحه علحى
إنجاز عمليات متابعة المشتركين الجدد من خاللة وبالشكل الذى يأمله الطرف األول وقحد تمحت الموافقحة محن الطحرف الثحاني عحن طريحق الحـ Application (
Digital ) بالموافقة عن طريق اشتراكة في البرنامج عن طريق قيام الطرف االول بارسال رسحالة نصحية الحي التليفحون المحمحول والبريحد االلكترونحى الخحا
بالطرف الثاني بما يفيد اشتراكة لدي الطرف االول وبعد أن أقر الطرفين بأهليتهما القانونية للتعاقد إتفقا فيما بينهما على ما يلى :
اوال
يعتبرالتمهيد السابق جزء ال يتجزاء من هذا العقد.
ثانيا
بموجب هذا العقد يرغب في ان يكون عميل مشترك لدي برنامج نتينج هاب علي شبكة االنترنت ) الموقع االفتراضي ( لدي الطرف االول .
ثالثا
5/9 . يستحق الطرف الثانى مقابل قيامة بادخال عمالء جدد ليقوم باالشتراك في البرنحامج عمولحة تححدد الحقحا وفقحا العمحال الطحرف االول محع الطحرف الثحانى
تستحق فى فى الشهر التالى.
5/2 . من المتفـق عليـه أن يتـم خصم الضرائب المســـتحقة من الطرف الثانى و آيه رسوم أو استقطاعات أخرى تن عليها القوانين .
5/3 . للطرف األول مطلق الحرية فى إختيار الطريقة التى يدفع بها مستحقات الطرف الثانى المذكور اعاله فى يكون السداد عن طريق التحويل البنكى لحساب
الطرف الثانى و فى هذه الحالة تبراء ذمة الطرف األول تجاه الطرف الثانى بهذا الخصو بمجرد تحويل مبلغ المستحق.
رابعا
يلتزم الطرف الثانى بما يلى :
7/9 . القيام بواجباتة لدى الطرف األول طبقا لشروط هذا العقد وطبقا ألحكام القوانين و اللوائ المعمول بها في جمهوريحة مصحر العربيحة والتحى اطلحع عليهحا
الطرف الثانى و قبلها .
7/2 . بعدم قبول أى أموال أو عمولة أو هدايا من أى نوع من العمالء نظير قيامه بادخال عمالء جدد والمسندة إليه من الطرف األول وكحذلك عحدم اإلقتحرا
من عمالء الطرف األول .
خامسا
يلتزم الطرف الثانى بأن يقدم للطرف األول كافة المستندات و البيانات المطلوبة منه للبدء فى العمل مع الطرف االول كما يلتزم بإخطار الطرف األول بأى تعديل
يطرأ على هذه البيانات أو المستندات خالل أسبوع على األكثر من تاريخ حدوث هذا التغيير و يكون مسئوال عن صحة تلك البيانات و المستندات و تقديمها فى
المواعيد المحددة و إال أعتبر العقد مفسوخا من تلقاء نفسة دون الحاجة إلى تنبية أو إنذار أو ثمة إجراءات أو الحصول على حكم يقضى بذلك .
سادسا
6/9 . يلتزم الطرف الثانى فى كل األوقات و تحت أى ظرف من الظروف بالحفاظ على سرية المعلومات المتعلقة بالطرف األول أو بأى من عمالءة أو شركاءه
فى العمل و ال يشترط أن تكون هذه المعلومات تحمل صفة السرية بل يمتد نطاق الحماية الى المعلومات كافة ، و من المتفق علية أن يمتد هحذا األلتحزام خحالل
فترة التعاقد و بعد إنتهاء فترة التعاقد أيضا ايا ما كان سبب هذا األنهاء و لغير فترة محدده و يشمل هذا األلتزام كافة األوراق الداخلية و األنظمة المعمول بها
فى الشركة الطرف االول وكذلك كافة برامج الحواسب والبنية التحتية لشبكة المعلومات الداخلية و كذا أسعار العموالت و أربا الشركة و خططها التسويقية و
التنموية و كافة العقود و المستندات و المراسالت و المكاتبات علما بأن ما ذكر على سحبيل المثحال و لحيس الحصحر و يححتفظ الطحرف األول محن األن بحقحه فحى
إتخاذ اإلجراءات القانونية ضد الطرف الثانى فى حـاله انتهاك سرية المعلومات الخاصة به و اإلفصا عنها الى طرف ثالث أيا ما كانت األسباب و كذلك بحقة
فى التعوي أن كان لة مقتضى .
6/2 . باختيار التعاقد ، يتنازل الطرف الثانى مقدما للطرف األول على وجه الخصو ، و بحدو ن ححد لعموميحة محا ذكحر انفحا عحن ححق نشحر محا يملكحه أو يحدعى
ملكيته، و يتصل بأية مادة علمية أو أى عمل آخر من إبداعه، سواء كان منفردا به أو بالتعاون مع آخحرين، وسحواء اخترعحه لعملحه أو فحى نطحاق العمحل الحذى
يقوم به و ذلك فى نطاق العمل فقط.
سابعا
يحق للطرف األول إنهاء العقد من جانبه و بعد إتخاذ اإلجراءات القانونية فى الحاالت األتية:
7/9 . إذا لم يلتزم الطرف الثانى بأحكام وشروط هذا العقد أو لم يلتزم بقواعد ولوائ وسياسات الطرف األول.
7/2 . إذا ارتكب الطرف الثانى خطأ جسيما أو خطا متعمدا تنشأ عنه خسائر فادحة للطرف األول.
7/3 . اذا قدم الطرف الثانى للطرف األول أية مستندات أو معلومات أو بيانات غيـر صحيحة تتعلق بالبيانات الشـخصية و التى على اساسها تم تعيينة .
7/4 . اذا أفشى سر من أسرار الطرف األول أو إنتهك سرية المعلومات و أفص عن أيا من المعلومات المحمية و يكون تقدير كون هذه المعلومة محمية أو
غير محمية للطرف األول وحده .
7/5 . اذا قام الطرف الثاني بمنافسة الطرف االول في ذات نشاطه او التحق اثناء عمله بشركة اخري منافسة أو ادي بها أو أنجز لها أي عمل من األعمال .
7/6 . يلتزم الطرف الثاني بالحفاظ علي سرية المبالغ المحوله اليه وعدم اطالع أحد عليه.
و يحق للطرف األول في هذه الحاالت مطالبة الطرف الثاني بالتعوي المناسب.
ثامنا
كل نزاع ينشأ بين الطرفين خاصأ بتنفيذ أو تفسير أي بند من بنود هذا العقد يكون الفصل فيه من اختصا محاكم جنوب القاهرة بجزئيتها
',
'sing_in'=> 'Sign In',
'thank_you'=> 'Thank You',
'thank_you_words'=> 'Please check your email and mobile sms for further instructions on how to complete your account setup' ,

'having_trouble' => 'Having trouble?',
'you_are_registered_go_app'=> 'you Are Registered Before Please Go to out  Application',
'email_or_phone_wrong'=>'Email or Phone Wrong',
"thank_you_for_pay" => 'Congratulations your order has been successfully Added',
        "whatsphone"=>'012-2243-6850'

    ],

];
