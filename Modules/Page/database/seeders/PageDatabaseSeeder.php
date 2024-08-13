<?php

namespace Modules\Page\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Page\Models\Page;

class PageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $pages = [
            [
                'name' => 'Privacy Policy',
                'sequence' => 1,
                'status' => 1,
                'type' => 'privacy-policy',
                'description' => '<p>This Privacy Policy is brought by Pitomec Design. Pitomec Design is the sole owner of a number of demo websites containing previews of WordPress website themes. This Privacy Policy shall apply to all Pitomec Design sites where this Privacy Policy is featured. This Privacy Policy describes how the Pitomec Design collects, uses, shares and secures personal information that you provide.</p><p>Pitomec Design does not share personal information of any kind with anyone. We will not sell or rent your name or personal information to any third party. We do not sell, rent or provide outside access to our mailing list or any data we store. Any data that a user stores via our facilities is wholly owned by that user or business. At any time, a user or business is free to take their data and leave, or to simply delete their data from our facilities.</p><p>Pitomec Design only collects specific personal information that is necessary for you to access and use our services. This personal information includes, but is not limited to, first and last name, email address, Country of residence.</p><p>Pitomec Design may release personal information if Pitomec Design is required to by law, search warrant, subpoena, court order or fraud investigation. We may also use personal information in a manner that does not identify you specifically nor allow you to be contacted but does identify certain criteria about our site’s users in general (such as we may inform third parties about the number of registered users, number of unique visitors, and the pages most frequently browsed).</p><p>&nbsp;</p><h5>Use of Information</h5><p><br></p><p>We use the information to enable your use of the site and its features and to assure security of use and prevent any potential abuse. We may use the information that we collect for a variety of purposes including:</p><p><strong>Promotion</strong>&nbsp;— With your consent we send promotional communications, such as providing you with information about products and services, features, surveys, newsletters, offers, promotions, contests and events;</p><p><strong>Safety and security</strong>&nbsp;— We use the information we have to verify accounts and activities, combat harmful conduct, detect and prevent spam and other bad experiences, maintain the integrity of the Platform, and promote safety and security.</p><p><strong>Product research and development</strong>&nbsp;— We use the information we have to develop, test and improve our Platform and Services, by conducting surveys and research, and testing and troubleshooting new products and features.</p><p><strong>Communication with you</strong>&nbsp;— We use the information we have to send you various communications, communicate with you about our products, and let you know about our policies and terms. We also use your information to respond to you when you contact us.</p><p>&nbsp;</p><h5>Amendments</h5><p><br></p><p>We may amend this Privacy Policy from time to time. When we amend this Privacy Policy, we will update this page accordingly and require you to accept the amendments in order to be permitted to continue using our services.</p><h5><br></h5><h5>Contact Us</h5><p>You can learn more about how privacy works within our site by contacting us. If you have questions about this Policy, you can contact us via email address provided. Additionally, we may also resolve any disputes you have with us in connection with our privacy policies and practices through direct contact. Write to us at&nbsp;<em>hello@Pitomec.design</em></p><h5><br></h5><h5>Data Deletion Request</h5><p>To ensure the safety and privacy of your data, we offer a streamlined process for requesting its removal from our servers. To initiate the deletion process, kindly send an email from your registered email address to our dedicated email inbox at hello@Pitomec.design Upon based on your request, our team will thoroughly examine the provided details and proceed with necessary actions in adherence to our privacy policies and legal obligations.</p>',
            ],
            [
                'name' => 'Terms & Conditions',
                'type' => 'terms-conditions',
                'sequence' => 2,
                'status' => 1,
                'description' => '<p>By accessing products on this site and placing an order from our website, you confirm that you are in agreement with and bound by the terms and conditions presented and outlined here. These terms apply to the entire website and any email or other type of communication between you and Pitomec Design. The Pitomec Design team is not liable for any direct, indirect, incidental or consequential damages, including, but not limited to, loss of data or profit, arising out of the use the materials on this site.</p><p>Pitomec Design will not be responsible for any outcome that may occur during the course of usage of our resources. We reserve the rights to change prices and revise the resources usage policy in any moment.</p><p>&nbsp;</p><h5><strong>Products</strong></h5><p><br></p><p>All products and services offered on this site are produced by Pitomec Design. You can access your download from your respective dashboard. We do not provide support for 3rd party software, plugins or libraries that you might have used with our products.</p><p>&nbsp;</p><h5>Security</h5><p><br></p><p>Pitomec Design does not process any order payments through the website. All payments are processed securely through RazorPay and Stripe, a third party online payment providers.</p><p>&nbsp;</p><h5>Cookie Policy</h5><p><br></p><p>A cookie is a file containing an identifier (a string of letters and numbers) that is sent by a web server to a web browser and is stored by the browser. The identifier is then sent back to the server each time the browser requests a page from the server. Our website uses cookies. By using our website and agreeing to this policy, you consent to our use of cookies in accordance with the terms of this policy.</p><p>We use session cookies to personalize the website for each user.</p><p>We use Google Analytics to analyze the use of our website. Our analytics service provider generates statistical and other information about website use by means of cookies. Deleting cookies will have a negative impact on the usability of the site. If you block cookies, you will not be able to use all the features on our website.</p><p>&nbsp;</p><h5>Refunds</h5><p><br></p><p>You can ask for refund against the item purchased under certain circumstances listed in our Refund Policy. In the event that you meet the applicable mark for receiving refund, Pitomec Design will issue you a refund and ask you to specify how the product turned down your item performance expectations.</p><p>&nbsp;</p><h5>Email</h5><p><br></p><p>By signing up on our website https://Pitomec.design you agree to receive emails from us – Transactional as well as promotional (occasional).</p><p>&nbsp;</p><h5>Ownership</h5><p><br></p><p>Ownership of the product is governed by the usage license.</p><p>&nbsp;</p><h5>Changes about terms</h5><p><br></p><p>We may change/update our terms of use without any prior notice. If we change our terms and condition, we will post those changes on this page. Users can check latest version in here.</p>',
            ],
        ];
        if (env('IS_DUMMY_DATA')) {
            foreach ($pages  as $key => $pages_data) {
                $pages = Page::create($pages_data);
            }
        }

    }
}
