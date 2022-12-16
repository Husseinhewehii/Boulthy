<?php

namespace Database\Seeders;

use App\Models\LanguageLine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaticContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [

            "clientregistrationpromoname" =>  "Registration Promo",
            "clientregistrationpromoshortdescription" =>  "Our Welcome Promo",
            "clientregistrationpromodescription" =>  "This is a Promo that we offer for every new Client",


            "orderintransitemailsubject" =>  "Your Order Is In Transit",
            "orderintransitemailmessage" =>  "Your Order Will be Delivered within 10 business Days",
            "ordershippedemailsubject" =>  "Your Order Has Been Shipped",
            "ordershippedemailmessage" =>  "Your Order Has Been Shipped Successfully",
            "orderdeliveredemailsubject" =>  "Your Order Has Been Delivered",
            "orderdeliveredemailmessage" =>  "Your Order Has Been Delivered Successfully",
            "ordercancelledemailsubject" =>  "Your Order Has Been Cancelled",
            "ordercancelledemailmessage" =>  "Your Order Has Been Cancelled and Payment Will Be Refunded Shortly",

            "commissionaddedemailsubject" =>  "Commission Added",
            "commissionaddedemailmessage" =>  "Your Commission Has Been Added To Your Wallet",
            "commissionreversedemailsubject" =>  "Commission Reversed",
            "commissionreversedemailmessage" =>  "Your Commission Has Been Reversed And Deducted From Your Wallet",
            "aboutdesc" => "Contains the highest precentag of Spirulina extraction Contains Natural oils with high percentage Fast effect",
            "add" => "Add",
            "addaddress" =>"Add Address",
            "additionalinformation" => "Additional Information",
            "address" => "Address",
            "addresses" => "Addresses",
            "addtocart" => "Add To Cart",
            "amount" => "Amount",
            "anyideas" => "Do you have any ideas?",
            "associatecommissionpercentage" => 1,
            "bestsellerstitle" => "BEST SELLER",
            "billingdetails" => "Billing Details",
            "cartdetails" => "Cart Details",
            "cartpagetilte" => "Cart",
            "categories" => "Categories",
            "checkoutpagetitle" => "Checkout",
            "clickheretoenteryourcode" => "Click here to enter your code",
            "clientregistrationpromodescription" => "This is a Promo that we offer for every new Client",
            "clientregistrationpromoname" => "Registration Promo",
            "clientregistrationpromopercentage" => 15,
            "clientregistrationpromoshortdescription" => "Our Welcome Promo",
            "clientregistrationpromotime" => 1296000,
            "close" => "Close",
            "comment" => "Comment",
            "comments" => "Comments",
            "commissionaddedemailmessage" => "Your Commission Has Been Added To Your Wallet",
            "commissionaddedemailsubject" => "Commission Added",
            "commissionreversedemailmessage" => "Your Commission Has Been Reversed And Deducted From Your Wallet",
            "commissionreversedemailsubject" => "Commission Reversed",
            "compemail" => "Feedback@Website.com",
            "compnumber" => "01050035528",
            "comptime" => "Working hours from 9 to 5",
            "confirmnewpassword" => "Confirm New Password",
            "confirmorder" => "Confirm Order",
            "contactusbtn" => "Contact Us",
            "couponcode" => "Coupon Code",
            "createdat" => "Created At",
            "credit" => "Credit",
            "currency" => "LE",
            "debit" => "Debit",
            "delete" => "Delete",
            "edit" => "Edit",
            "email" => "Email",
            "entery" => "Entery",
            "entry" => "Entry",
            "establishmentdesc" => "Beaulthy is a hair and skin care and beauty brand that believes that using healthier ingredients results in healthier hair and skin. Beaulthy adheres to the business philosophy of “green, natural, and healthy,” and is committed to providing the highest quality skin and hair products to our customers, bringing the natural superfood to the world, so that people all over the MENA region can enjoy the benefits of natural Spirulina as the savior of all hair and skin problems. Spirulina is known as the “miracle algae” because of its many health properties, it is rich in iron, zinc and potassium, it is a real super food ideal for good health. In addition, spirulina has powerful properties for the beauty of the skin, hair. We dedicated our time, experience, and effort to scientific study in order to present our top professionals with all of the information and resources they need to prove that Spirulina is the first, last, and only answer for resolving hair and skin problems successfully and in a timely manner.",
            "establishmenttitle" => "LET'S TALK ABOUT BEAUTY",
            "facebooklink" => "https://www.facebook.com/",
            "fees" => "Fees",
            "fess" => "Fess",
            "firstname" => "First Name",
            "footertitle1" => "Company",
            "footertitle2" => "Support",
            "footertitle3" => "Get Social",
            "getintouch" => "Let Get In Touch!",
            "getintouchdesc" => "Ready to start your next project with us? That great! Give us a call or send us an email and we will get back to you as soon as possible!",
            "haveacoupon" => "Have a coupon?",
            "id" => "Id",
            "ifyouhaveacouponcode" => "If you have a coupon code, please apply it below.",
            "instagramlink" => "https://www.instagram.com/",
            "joinusnow" => "Join Us Now",
            "justforyoutitle" => "JUST FOR YOU",
            "lastname" => "Last Name",
            "loading" => "Loading",
            "login" => "Login",
            "logout" => "Log Out",
            "message" => "Message",
            "mission" => "Mission",
            "missiondesc" => "To create effective, innovative products that respect both nature and people by providing the perfect union of science and plant heritage. We believe in a more responsible world and acts every day, through simple and concrete actions, to create innovative products from the mother nature for the benefit of all who suffer from damaged hair & tired dull skin. We worked hard to achieve the concept of being the first & only plant-powered hair and skincare which is Carefully crafted by us, and inspired by you.",
            "myaccount" => "My Account",
            "myorders" => "My Orders",
            "name" => "Name",
            "navbarlinkabout" => "About Us",
            "navbarlinkblogs" => "Blogs",
            "navbarlinkcareers" => "Careers",
            "navbarlinkcontact" => "Contact Us",
            "navbarlinkhome" => "Home",
            "navbarlinkpartners" => "Our Partners",
            "navbarlinkshop" => "Shop",
            "newpassword" => "New Password",
            "notes" => "Notes",
            "oldpassword" => "Old Password",
            "orderfees" => "15",
            "orderid" => "Order Id",
            "ordernotes" => "Order notes (optional)",
            "our" => "Our",
            "pagedesc" => "Whether you need eye makeup for a killer cat eye or face makeup to get a flawless complexion, L’Oréal Paris helps make your beauty routineveven better. From our latest product launches to our cult classics—Lash Voluminous, anyone?—we have the cosmetics you need to  keep your beauty stash stocked with the best!",
            "pagetilte" => "Cart",
            "pagetitle" => "Makeup",
            "paymentmethod" => "Payment Method",
            "phone" => "Phone",
            "pleaseleave" => "Please leave your information and we will contact you as soon as possible!",
            "price" => "Price",
            "proceedtocheckout" => "Proceed to checkout",
            "product" => "Product",
            "promos" => "Promos",
            "quantity" => "Quantity",
            "readmore" => "Read More",
            "relatedproducts" => "Related Products",
            "reset" => "Reset",
            "resetpassword" => "Reset Password",
            "results" => "Results",
            "rights" => "BEAULTHY 2021, All Rights Reserved.",
            "seemore" => "See More",
            "send" => "Send",
            "shoppagetitle" => "Makeup",
            "shortdes1" => "",
            "shortdes2" => "Features of Our Products",
            "showmore" => "Show More",
            "signup" => "Sign Up",
            "subject" => "Subject",
            "subtotal" => "Subtotal",
            "subtotalafterpromos" => "Sub Total After Promos",
            "test" => "test2",
            "total" => "Total",
            "transaction" => "Transaction",
            "transactions" => "Transactions",
            "twitterklink" => "https://www.twitter.com/”",
            "twitterlink" => "https://www.instagram.com/",
            "updateorderinformation" => "Update Order Information",
            "updatepassword" => "Update Password",
            "uploadcv" => "Upload Your C.V",
            "verifyyouraccount" => "Verify Your Account",
            "vision" => "Vision",
            "visiondesc" => "We strive to be the one and only natural brand with spirulina, which is known as the best hair and skin routine, the first and last problem solver for all hair and skin problems, as well as providing scientific knowledge to all of our customers on how to get a healthy and natural new look that lasts a lifetime.",
            "writecomment" => "Write Comment",
            "youmustloginfirst" => "You must login first",
            "yourcartisempty" => "Your cart is empty",
            "yourorder" => "Your Order",
            "youtubelink" => "https://www.youtube.com/",
            "location"  =>" location",
            "newslettertitle"  =>" newsletter",
            "newsletterdesc"  =>" newsletterDesc",
            "footerdesc"  =>" FooterDesc",
            "blogsdesc"  =>" blogsDesc",
            "reviewtitle"  =>" Review_title",
            "reviewproduct" => "Review__product",
            "reviewdesc" => "Review_ desc",
            "moredescproduct" => "More_desc_product",
            "rating" => "Rating",
            "addtowishlist" => "Add_to_wishlist",
            "cashondelivery"  =>" Cash On Delivery",
            "visaondelivery"  =>" visa On Delivery",
            "creditcard" => "credit card",
            "recentpost" => "Recent_Post"
        ];

        $this->reset_tables();
        foreach ($settings as $key => $text) {
            // LanguageLine::firstOrCreate(["group" => "settings", "key"=> $key], ["group" => "settings", "key"=> $key, "text" => $text]);
            $items[] = ["group" => "settings", "key"=> $key, "text" => $text];
        }
        LanguageLine::insert($items);
    }

    public function reset_tables()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('language_lines')->truncate();
        DB::statement("SET foreign_key_checks=1");
    }
}
