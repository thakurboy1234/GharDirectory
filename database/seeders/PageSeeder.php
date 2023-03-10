<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\LanguageAdvanced\Models\PageTranslation;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Html;
use Illuminate\Support\Str;
use SlugHelper;

class PageSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'name' => 'Home',
                'content' =>
                    Html::tag('div', '[search-box title="Find your favorite homes at Flex Home" background_image="general/home-banner.jpg" enable_search_projects_on_homepage_search="yes" default_home_search_type="project"][/search-box]') .
                    Html::tag('div', '[featured-projects title="Featured projects" subtitle="We make the best choices with the hottest and most prestigious projects, please visit the details below to find out more."][/featured-projects]') .
                    Html::tag('div', '[properties-by-locations title="Properties by locations" subtitle="Each place is a good choice, it will help you make the right decision, do not miss the opportunity to discover our wonderful properties."][/properties-by-locations]') .
                    Html::tag('div', '[properties-for-sale title="Properties For Sale" subtitle="Below is a list of properties that are currently up for sale"][/properties-for-sale]') .
                    Html::tag('div', '[properties-for-rent title="Properties For Rent" subtitle="Below is a detailed price list of each property for rent"][/properties-for-rent]') .
                    Html::tag('div', '[featured-agents title="Featured Agents"][/featured-agents]') .
                    Html::tag(
                        'div',
                        '[recently-viewed-properties title="Recently Viewed Properties" subtitle="Your currently viewed properties."][/recently-viewed-properties]'
                    ) .
                    Html::tag('div', '[latest-news title="News" subtitle="Below is the latest real estate news we get regularly updated from reliable sources."][/latest-news]')
                ,
                'template' => 'homepage',
            ],
            [
                'name' => 'News',
                'content' => '---',
                'template' => 'default',
            ],
            [
                'name' => 'About us',
                'description' => 'Founded on August 28, 1993 (formerly known as Truong Thinh Phat Construction Co., Ltd.), Flex Home operates in the field of real estate business, building villas for rent.
With the slogan "Breaking time, through space" with a sustainable development strategy, taking Real Estate as a focus area, Flex Home is constantly connecting between buyers and sellers in the field.',
                'content' => '<h4><span style="font-size:18px;"><b>1. COMPANY</b><span style="font-family:Arial,Helvetica,sans-serif;"><strong> PROFILE</strong></span></span></h4>

<p><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Founded on August 28, 1993 (formerly known as Truong Thinh Phat Construction Co., Ltd.), Flex Home operates in the field of real estate business, building villas for rent.<br />
With the slogan &quot;Breaking time, through space&quot; with a sustainable development strategy, taking Real Estate as a focus area, Flex Home is constantly connecting between buyers and sellers in the field. Real estate, bringing people closer together, over the distance of time and space, is a reliable place for real estate investment - an area that is constantly evolving over time.</span></span></p>

<blockquote>
<h2 style="font-style: italic; text-align: center;"><span style="font-size:24px;"><strong><span style="font-family:Arial,Helvetica,sans-serif;"><span style="color:#16a085;">&quot;Breaking time, through space&quot;</span></span></strong></span></h2>
</blockquote>

<h4 style="text-align: center;"><img alt="" src="' . url('') . '/storage/general/asset-3-at-3x.png" style="width: 90%;" /></h4>

<h4><span style="font-size:18px;"><b><font face="Arial, Helvetica, sans-serif">2. VISION&nbsp;</font></b></span></h4>

<p><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">- Acquiring domestic areas.<br />
- Reaching far across continents.</span></span></p>

<h4><span style="font-size:18px;"><b>3. MISSION</b></span></h4>

<p><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">- Creating the community<br />
- Building destinations<br />
- Nurture happiness</span></span></p>

<p><img alt="" src="' . url('') . '/storage/general/vietnam-office-4.jpg" /></p>
',
                'template' => 'default',
            ],
            [
                'name' => 'Contact',
                'content' => '<p>[contact-form][/contact-form]<br />
&nbsp;</p>

<h3>Directions</h3>

<p>[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]</p>

<p>&nbsp;</p>',
                'template' => 'default',
            ],
            [
                'name' => 'Terms & Conditions',
                'description' => 'Copyrights and other intellectual property rights to all text, images, audio, software and other content on this site are owned by Flex Home and its affiliates. Users are allowed to view the contents of the website, cite the contents by printing, downloading the hard disk and distributing it to others for non-commercial purposes.',
                'content' => '<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Access to and use of the Flex Home website is subject to the following terms, conditions, and relevant laws of Vietnam.</span></span></p>

<h4 style="text-align: justify;"><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>1. Copyright</strong></span></span></h4>

<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Copyrights and other intellectual property rights to all text, images, audio, software and other content on this site are owned by Flex Home and its affiliates. Users are allowed to view the contents of the website, cite the contents by printing, downloading the hard disk and distributing it to others for non-commercial purposes, providing information or personal purposes. </span></span><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Any content from this site may not be used for sale or distribution for profit, nor may it be edited or included in any other publication or website.</span></span></p>

<h4 style="text-align: justify;"><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>2. Content</strong></span></span></h4>

<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">The information on this website is compiled with great confidence but for general information research purposes only. While we endeavor to maintain updated and accurate information, we make no representations or warranties in any manner regarding completeness, accuracy, reliability, appropriateness or availability in relation to web site, or related information, product, service, or image within the website for any purpose. </span></span></p>

<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Flex Home and its employees, managers, and agents are not responsible for any loss, damage or expense incurred as a result of accessing and using this website and the sites. </span></span><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">The web is connected to it, including but not limited to, loss of profits, direct or indirect losses. We are also not responsible, or jointly responsible, if the site is temporarily inaccessible due to technical issues beyond our control. Any comments, suggestions, images, ideas and other information or materials that users submit to us through this site will become our exclusive property, including the right to may arise in the future associated with us.</span></span></p>

<p style="text-align: center;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;"><img alt="" src="' . url('') . '/storage/general/copyright.jpg" style="width: 90%;" /></span></span></p>

<h4 style="text-align: justify;"><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>3. Note on&nbsp;connected sites</strong></span></span></h4>

<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">At many points in the website, users can get links to other websites related to a specific aspect. This does not mean that we are related to the websites or companies that own these websites. Although we intend to connect users to sites of interest, we are not responsible or jointly responsible for our employees, managers, or representatives. with other websites and information contained therein.</span></span></p>
',
                'template' => 'default',
            ],
            [
                'name' => 'Cookie Policy',
                'content' => Html::tag('h3', 'EU Cookie Consent') .
                    Html::tag(
                        'p',
                        'To use this website we are using Cookies and collecting some Data. To be compliant with the EU GDPR we give you to choose if you allow us to use certain Cookies and to collect some Data.'
                    ) .
                    Html::tag('h4', 'Essential Data') .
                    Html::tag(
                        'p',
                        'The Essential Data is needed to run the Site you are visiting technically. You can not deactivate them.'
                    ) .
                    Html::tag(
                        'p',
                        '- Session Cookie: PHP uses a Cookie to identify user sessions. Without this Cookie the Website is not working.'
                    ) .
                    Html::tag(
                        'p',
                        '- XSRF-Token Cookie: Laravel automatically generates a CSRF "token" for each active user session managed by the application. This token is used to verify that the authenticated user is the one actually making the requests to the application.'
                    ),
                'template' => 'default',
            ],
        ];

        Page::truncate();
        PageTranslation::truncate();
        Slug::where('reference_type', Page::class)->delete();
        MetaBoxModel::where('reference_type', Page::class)->delete();
        LanguageMeta::where('reference_type', Page::class)->delete();

        foreach ($pages as $item) {
            $item['user_id'] = 1;
            $page = Page::create($item);

            Slug::create([
                'reference_type' => Page::class,
                'reference_id' => $page->id,
                'key' => Str::slug($page->name),
                'prefix' => SlugHelper::getPrefix(Page::class),
            ]);
        }

        $translations = [
            [
                'name' => 'Trang ch???',
                'content' =>
                    Html::tag('div', '[search-box title="T??m ki???m ng??i nh?? m?? ?????c c???a b???n t???i Flex Home" background_image="general/home-banner.jpg" enable_search_projects_on_homepage_search="yes" default_home_search_type="project"][/search-box]') .
                    Html::tag('div', '[featured-projects title="D??? ??n n???i b???t" subtitle="Ch??ng t??i ????a ra nh???ng l???a ch???n t???t nh???t v???i nh???ng d??? ??n hot nh???t v?? uy t??n nh???t, vui l??ng truy c???p chi ti???t b??n d?????i ????? t??m hi???u th??m."][/featured-projects]') .
                    Html::tag('div', '[properties-by-locations title="B???t ?????ng s???n theo khu v???c" subtitle="M???i n??i l?? m???t s??? l???a ch???n t???t s??? gi??p b???n ????a ra quy???t ?????nh ????ng ?????n, ?????ng b??? l??? c?? h???i kh??m ph?? nh???ng b???t ?????ng s???n tuy???t v???i c???a ch??ng t??i."][/properties-by-locations]') .
                    Html::tag('div', '[properties-for-sale title="B???t ?????ng s???n b??n" subtitle="D?????i ????y l?? danh s??ch c??c b???t ?????ng s???n hi???n ??ang ???????c b??n."][/properties-for-sale]') .
                    Html::tag('div', '[properties-for-rent title="B???t ?????ng s???n ??? cho thu??" subtitle="D?????i ????y l?? danh s??ch c??c b???t ?????ng s???n hi???n ??ang ???????c cho thu??."][/properties-for-rent]') .
                    Html::tag('div', '[featured-agents title="?????i l?? n???i b???t"][/featured-agents]') .
                    Html::tag('div', '[recently-viewed-properties title="Nh??/c??n h??? ???? xem" description="C??c c??n h???/nh?? m?? b???n ???? xem."][/recently-viewed-properties]') .
                    Html::tag('div', '[latest-news title="Tin t???c" subtitle="D?????i ????y l?? tin t???c b???t ?????ng s???n m???i nh???t ???????c ch??ng t??i c???p nh???t th?????ng xuy??n t??? c??c ngu???n ????ng tin c???y."][/latest-news]')
                ,
            ],
            [
                'name' => 'Tin t???c',
                'content' => '---',
            ],
            [
                'name' => 'V??? ch??ng t??i',
                'description' => '???????c th??nh l???p ng??y 28 - 08 -1993 (ti???n th??n l?? c??ng ty TNHH X??y D???ng Tr?????ng Th???nh Ph??t), Flex Home ho???t ?????ng trong l??nh v???c kinh doanh b???t ?????ng s???n, x??y bi???t th??? cho thu??.??V???i kh???u hi???u ?????????nh b???t th???i gian, xuy??n qua kh??ng gian??? c??ng chi???n l?????c ph??t tri???n b???n v???ng, Flex Home kh??ng ng???ng k???t n???i gi???a ng?????i c???n mua v?? ng?????i c???n b??n trong l??nh v???c b???t ?????ng s???n',
                'content' => '<h4><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>1. S?? L?????C V??? C&Ocirc;NG TY</strong></span></span></h4>

<p><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">???????c th&agrave;nh l???p ng&agrave;y 28 - 08 -1993 (ti???n th&acirc;n l&agrave; c&ocirc;ng ty TNHH X&acirc;y D???ng Tr?????ng Th???nh Ph&aacute;t), Flex Home ho???t ?????ng trong l??nh v???c kinh doanh b???t ?????ng s???n, x&acirc;y bi???t th??? cho thu&ecirc;.&nbsp;<br />
V???i kh???u hi???u &nbsp;&ldquo;??&aacute;nh b???t th???i gian, xuy&ecirc;n qua kh&ocirc;ng gian&rdquo; c&ugrave;ng chi???n l?????c ph&aacute;t tri???n b???n v???ng, l???y B???t ?????ng S???n l&agrave;m l??nh v???c tr???ng t&acirc;m, Flex Home kh&ocirc;ng ng???ng k???t n???i gi???a ng?????i c???n mua v&agrave; ng?????i c???n b&aacute;n trong l??nh v???c b???t ?????ng s???n, ????a m???i ng?????i x&iacute;ch l???i g???n nhau h??n, v?????t qua kho???ng c&aacute;ch v??? th???i gian v&agrave; kh&ocirc;ng gian, l&agrave; n??i ??&aacute;ng tin t?????ng cho s??? ?????u t?? b???t ?????ng s???n - m???t l??nh v???c kh&ocirc;ng ng???ng ph&aacute;t tri???n qua th???i gian.</span></span></p>

<blockquote>
<h3 style="text-align: center;"><span style="font-size:24px;"><span style="font-family:Arial,Helvetica,sans-serif;"><em><strong><span style="color:#1abc9c;">&ldquo;??&aacute;nh b???t th???i gian, xuy&ecirc;n qua kh&ocirc;ng gian&rdquo; </span></strong></em></span></span></h3>
</blockquote>

<h3 style="text-align: center;"><img alt="" src="' . url('') . '/storage/general/asset-4-at-3x.png" style="width: 90%;" /></h3>

<h4><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>2. T???M NH&Igrave;N</strong></span></span></h4>

<ul>
	<li><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Th&acirc;u t&oacute;m ?????a b&agrave;n trong n?????c.</span></span></li>
	<li><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">V????n xa kh???p c&aacute;c ch&acirc;u l???c.</span></span></li>
</ul>

<h4><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>3. S??? M???NG</strong></span></span></h4>

<ul>
	<li><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Ki???n t???o c???ng ?????ng</span></span></li>
	<li><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">X&acirc;y d???ng ??i???m ?????n</span></span></li>
	<li><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Vun ?????p ni???m vui</span></span></li>
</ul>

<p>&nbsp;</p>

<p><img alt="" src="' . url('') . '/storage/general/vietnam-office-4.jpg" style="width: 100%;" /></p>

<p>&nbsp;</p>
',
            ],
            [
                'name' => 'Li??n h???',
                'content' => '<p>[contact-form][/contact-form]<br />
&nbsp;</p>

<h3>T??m ???????ng ??i</h3>

<p>[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]</p>

<p>&nbsp;</p>',
            ],
            [
                'name' => '??i???u kho???n v?? quy ?????nh',
                'description' => 'Quy???n t??c gi??? v?? c??c quy???n s??? h???u tr?? tu??? kh??c ?????i v???i m???i v??n b???n, h??nh ???nh, ??m thanh, ph???n m???m v?? c??c n???i dung kh??c tr??n trang web n??y thu???c quy???n s??? h???u c???a Flex Home c??ng c??c c??ng ty th??nh vi??n. Ng?????i truy c???p ???????c ph??p xem c??c n???i dung trong trang web, tr??ch d???n n???i dung b???ng c??ch in ???n, t???i v??? ????a c???ng v?? ph??n ph??t cho ng?????i kh??c ch??? v???i m???c ????ch phi th????ng m???i.',
                'content' => '<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Vi???c truy c???p v&agrave; s??? d???ng trang web c???a Flex Home ph??? thu???c v&agrave;o nh???ng ??i???u kho???n, ??i???u ki???n d?????i ??&acirc;y, v&agrave; lu???t ph&aacute;p li&ecirc;n quan c???a Vi???t Nam.</span></span></p>

<h4 style="text-align: justify;"><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>1. Quy???n t&aacute;c gi???&nbsp;</strong></span></span></h4>

<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Quy???n t&aacute;c gi??? v&agrave; c&aacute;c quy???n s??? h???u tr&iacute; tu??? kh&aacute;c ?????i v???i m???i v??n b???n, h&igrave;nh ???nh, &acirc;m thanh, ph???n m???m v&agrave; c&aacute;c n???i dung kh&aacute;c tr&ecirc;n trang web n&agrave;y thu???c quy???n s??? h???u c???a Flex Home c&ugrave;ng c&aacute;c c&ocirc;ng ty th&agrave;nh vi&ecirc;n. Ng?????i truy c???p ???????c ph&eacute;p xem c&aacute;c n???i dung trong trang web, tr&iacute;ch d???n n???i dung b???ng c&aacute;ch in ???n, t???i v??? ????a c???ng v&agrave; ph&acirc;n ph&aacute;t cho ng?????i kh&aacute;c ch??? v???i m???c ??&iacute;ch phi th????ng m???i, cung c???p th&ocirc;ng tin ho???c m???c ??&iacute;ch c&aacute; nh&acirc;n. B???t k??? n???i dung n&agrave;o t??? trang web n&agrave;y ?????u kh&ocirc;ng ???????c s??? d???ng ????? b&aacute;n ho???c ph&acirc;n t&aacute;n ????? ki???m l???i v&agrave; c??ng kh&ocirc;ng ???????c ch???nh s???a ho???c ????a v&agrave;o b???t k??? ???n ph???m ho???c trang web n&agrave;o kh&aacute;c.</span></span></p>

<h4 style="text-align: justify;"><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>2. N???i dung</strong></span></span></h4>

<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Th&ocirc;ng tin tr&ecirc;n trang web n&agrave;y ???????c bi&ecirc;n so???n v???i s??? tin t?????ng cao ????? nh??ng ch??? d&agrave;nh cho c&aacute;c m???c ??&iacute;ch nghi&ecirc;n c???u th&ocirc;ng tin t???ng qu&aacute;t. Tuy ch&uacute;ng t&ocirc;i n??? l???c duy tr&igrave; th&ocirc;ng tin c???p nh???t v&agrave; chu???n x&aacute;c, nh??ng ch&uacute;ng t&ocirc;i kh&ocirc;ng kh???ng ?????nh hay b???o ?????m theo b???t k??? c&aacute;ch th???c n&agrave;o v??? s??? ?????y ?????, ch&iacute;nh x&aacute;c, ??&aacute;ng tin c???y, th&iacute;ch h???p ho???c c&oacute; s???n li&ecirc;n quan ?????n trang web, ho???c th&ocirc;ng tin, s???n ph???m, d???ch v???, ho???c h&igrave;nh ???nh li&ecirc;n quan trong trang web v&igrave; b???t c??? m???c ??&iacute;ch g&igrave;. </span></span></p>

<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">Flex Home v&agrave; m???i nh&acirc;n vi&ecirc;n, nh&agrave; qu???n l&yacute;, v&agrave; c&aacute;c b&ecirc;n ?????i di???n ho&agrave;n to&agrave;n kh&ocirc;ng ch???u tr&aacute;ch nhi???m g&igrave; ?????i v???i b???t k??? t???n th???t, thi???t h???i ho???c chi ph&iacute; ph&aacute;t sinh do vi???c truy c???p v&agrave; s??? d???ng trang web n&agrave;y v&agrave; c&aacute;c trang web ???????c k???t n???i v???i n&oacute;, bao g???m nh??ng kh&ocirc;ng gi???i h???n, vi???c m???t ??i l???i nhu???n, c&aacute;c kho???n l??? tr???c ti???p ho???c gi&aacute;n ti???p. Ch&uacute;ng t&ocirc;i c??ng kh&ocirc;ng ch???u tr&aacute;ch nhi???m, ho???c li&ecirc;n ?????i tr&aacute;ch nhi???m n???u trang web t???m th???i kh&ocirc;ng th??? truy c???p do c&aacute;c v???n ????? k??? thu???t n???m ngo&agrave;i t???m ki???m so&aacute;t c???a ch&uacute;ng t&ocirc;i. M???i b&igrave;nh lu???n, g???i &yacute;, h&igrave;nh ???nh, &yacute; t?????ng v&agrave; nh???ng th&ocirc;ng tin hay t&agrave;i li???u kh&aacute;c m&agrave; ng?????i s??? d???ng chuy???n cho ch&uacute;ng t&ocirc;i th&ocirc;ng qua trang web n&agrave;y s??? tr??? th&agrave;nh t&agrave;i s???n ?????c quy???n c???a ch&uacute;ng t&ocirc;i, bao g???m c??? c&aacute;c quy???n c&oacute; th??? ph&aacute;t sinh trong t????ng lai g???n li???n v???i ch&uacute;ng t&ocirc;i.</span></span></p>

<p style="text-align:center"><img alt="" src="' . url('') . '/storage/general/copyright.jpg" style="width: 90%;" /></p>

<h4 style="text-align: justify;"><span style="font-size:18px;"><span style="font-family:Arial,Helvetica,sans-serif;"><strong>3. L??u &yacute; c&aacute;c trang web ???????c k???t n???i</strong></span></span></h4>

<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">T???i nhi???u ??i???m trong trang web, ng?????i s??? d???ng c&oacute; th??? nh???n ???????c c&aacute;c k???t n???i ?????n c&aacute;c trang web kh&aacute;c li&ecirc;n quan ?????n m???t kh&iacute;a c???nh c??? th???. ??i???u n&agrave;y kh&ocirc;ng c&oacute; ngh??a l&agrave; ch&uacute;ng t&ocirc;i c&oacute; li&ecirc;n quan ?????n nh???ng trang web hay c&ocirc;ng ty s??? h???u nh???ng trang web n&agrave;y. D&ugrave; ch&uacute;ng t&ocirc;i c&oacute; &yacute; ?????nh k???t n???i ng?????i s??? d???ng ?????n c&aacute;c trang web c???n quan t&acirc;m, nh??ng ch&uacute;ng t&ocirc;i v&agrave; c&aacute;c nh&acirc;n vi&ecirc;n, nh&agrave; qu???n l&yacute;, ho???c c&aacute;c b&ecirc;n ?????i di???n ho&agrave;n to&agrave;n kh&ocirc;ng ch???u tr&aacute;ch nhi???m ho???c li&ecirc;n ?????i ch???u tr&aacute;ch nhi???m g&igrave; ?????i v???i c&aacute;c trang web kh&aacute;c v&agrave; th&ocirc;ng tin ch???a ?????ng trong ??&oacute;.</span></span></p>
<p style="text-align: justify;"><span style="font-size:16px;"><span style="font-family:Arial,Helvetica,sans-serif;">At many points in the website, users can get links to other websites related to a specific aspect. This does not mean that we are related to the websites or companies that own these websites. Although we intend to connect users to sites of interest, we are not responsible or jointly responsible for our employees, managers, or representatives. with other websites and information contained therein.</span></span></p>
',
            ],
            [
                'name' => 'Cookie Policy',
                'content' => Html::tag('h3', 'EU Cookie Consent') .
                    Html::tag(
                        'p',
                        '????? s??? d???ng trang web n??y, ch??ng t??i ??ang s??? d???ng Cookie v?? thu th???p m???t s??? D??? li???u. ????? tu??n th??? GDPR c???a Li??n minh Ch??u ??u, ch??ng t??i cho b???n l???a ch???n n???u b???n cho ph??p ch??ng t??i s??? d???ng m???t s??? Cookie nh???t ?????nh v?? thu th???p m???t s??? D??? li???u.'
                    ) .
                    Html::tag('h4', 'D??? li???u c???n thi???t') .
                    Html::tag(
                        'p',
                        'D??? li???u c???n thi???t l?? c???n thi???t ????? ch???y Trang web b???n ??ang truy c???p v??? m???t k??? thu???t. B???n kh??ng th??? h???y k??ch ho???t ch??ng.'
                    ) .
                    Html::tag(
                        'p',
                        '- Session Cookie: PHP s??? d???ng Cookie ????? x??c ?????nh phi??n c???a ng?????i d??ng. N???u kh??ng c?? Cookie n??y, trang web s??? kh??ng ho???t ?????ng.'
                    ) .
                    Html::tag(
                        'p',
                        '- XSRF-Token Cookie: Laravel t??? ?????ng t???o "token" CSRF cho m???i phi??n ng?????i d??ng ??ang ho???t ?????ng do ???ng d???ng qu???n l??. Token n??y ???????c s??? d???ng ????? x??c minh r???ng ng?????i d??ng ???? x??c th???c l?? ng?????i th???c s??? ????a ra y??u c???u ?????i v???i ???ng d???ng.'
                    ),
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['pages_id'] = $index + 1;

            PageTranslation::insert($item);
        }
    }
}
