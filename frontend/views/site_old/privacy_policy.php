<?php
  use yii\helpers\Url;
  use yii\helpers\FileHelper;
  use common\components\ConnectionSettings;

  /* @var $this yii\web\View */
  $this->title = 'About';
  $this->context->layout = 'index';
  $this->registerJsFile('@web/js/site.js');
?>

<div id="wrapper-content" class="content-page"><!-- PAGE WRAPPER-->
    <div id="page-wrapper"><!-- MAIN CONTENT-->
        <div class="main-content"><!-- CONTENT-->
            <div class="content"><!-- SLIDER BANNER-->
                <div class="section-padding">
        	        <div class="container">
            	        <div class="row">
                	        <div class="col-sm-12">
                                <p>
                                This privacy policy has been compiled to better serve those who are concerned with how their 'Personally Identifiable Information' (PII) is being used online. PII, as described in US privacy law and information security, is information that can be used on its own or with other information to identify, contact, or locate a single person, or to identify an individual in context. Please read our privacy policy carefully to get a clear understanding of how we collect, use, protect or otherwise handle your Personally Identifiable Information in accordance with our website.</p>

                                <p>
                                    <strong>What personal information do we collect from the people that visit our blog, website or app?</strong>
                                    <p>When ordering or registering on our site, as appropriate, you may be asked to enter your name, email address, mailing address, phone number or other details to help you with your experience.</p>
                                </p>
                                <p>
                                    <strong>When do we collect information?</strong>
                                    <p>We collect information from you when you register on our site, place an order, subscribe to a newsletter, fill out a form, Use Live Chat, Open a Support Ticket or enter information on our site.
                                    <br/>Provide us with feedback on our products or services
                                    </p>
                                </p>
                                <p>
                                    <strong>How do we use your information?</strong>
                                    <p>We may use the information we collect from you when you register, make a purchase, sign up for our newsletter, respond to a survey or marketing communication, surf the website, or use certain other site features in the following ways:</p>
                                    <ul>
                                        <li>To personalize your experience and to allow us to deliver the type of content and product offerings in which you are most interested</li>
                                        <li>To improve our website in order to better serve you</li>
                                        <li>To allow us to better service you in responding to your customer service requests</li>
                                        <li>To administer a contest, promotion, survey or other site feature</li>
                                        <li>To quickly process your transactions</li>
                                        <li>To ask for ratings and reviews of services or products</li>
                                        <li>To follow up with them after correspondence (live chat, email or phone inquiries)</li>
                                    </ul>
                                </p>
                                <p>
                                    <strong>How do we protect your information?</strong>
                                    <p>We do not use vulnerability scanning and/or scanning to PCI standards.
                                        We only provide articles and information. We never ask for credit card numbers.
                                        We use regular Malware Scanning.
                                        <br/>
                                        Your personal information is contained behind secured networks and is only accessible by a limited number of persons who have special access rights to such systems, and are required to keep the information confidential. In addition, all sensitive/credit information you supply is encrypted via Secure Socket Layer (SSL) technology.
                                        <br/>
                                        We implement a variety of security measures when a user places an order enters, submits, or accesses their information to maintain the safety of your personal information.
                                        <br/>
                                        All transactions are processed through a gateway provider and are not stored or processed on our servers.
                                    </p>
                                </p>
                                <p>
                                    <strong>We use cookies to:</strong>
                                    <ul>
                                        <li>Help remember and process the items in the shopping cart.</li>
                                        <li>Understand and save user's preferences for future visits.</li>
                                        <li>Keep track of advertisements.</li>
                                        <li>Compile aggregate data about site traffic and site interactions in order to offer better site experiences and tools in the future. We may also use trusted third-party services that track this information on our behalf.</li>
                                        <p>You can choose to have your computer warn you each time a cookie is being sent, or you can choose to turn off all cookies. You do this through your browser settings. Since browser is a little different, look at your browser's Help Menu to learn the correct way to modify your cookies.
                                        <br/>
                                        If you turn cookies off, some features will be disabled. It won't affect the user's experience that make your site experience more efficient and may not function properly.
                                        However, you will still be able to place orders .
                                        </p>
                                    </ul>
                                </p>
                                <p>
                                    <strong>Third-party disclosure</strong>
                                    <p>We do not sell, trade, or otherwise transfer to outside parties your Personally Identifiable Information unless we provide users with advance notice. This does not include website hosting partners and other parties who assist us in operating our website, conducting our business, or serving our users, so long as those parties agree to keep this information confidential. We may also release information when it's release is appropriate to comply with the law, enforce our site policies, or protect ours or others' rights, property or safety.
                                    <br/>
                                    However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.
                                    </p>
                                </p>
                                <p>
                                    <strong>Third-party links</strong>
                                    <p>Occasionally, at our discretion, we may include or offer third-party products or services on our website. These third-party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.</p>
                                </p>
                                <p>
                                    <strong>Google</strong>
                                    <p>Google's advertising requirements can be summed up by Google's Advertising Principles. They are put in place to provide a positive experience for users. https://support.google.com/adwordspolicy/answer/1316548?hl=en
                                    <br/>
                                    We use Google AdSense Advertising on our website.
                                    <br/>
                                    Google, as a third-party vendor, uses cookies to serve ads on our site. Google's use of the DART cookie enables it to serve ads to our users based on previous visits to our site and other sites on the Internet. Users may opt-out of the use of the DART cookie by visiting the Google Ad and Content Network privacy policy.
                                    </p>
                                </p>
                                <p>
                                    <strong>We have implemented the following:</strong>
                                    <ul>
                                        <li>Google Display Network Impression Reporting</li>
                                        <li>Demographics and Interests Reporting</li>
                                    </ul>
                                    <p>
                                    We, along with third-party vendors such as Google use first-party cookies (such as the Google Analytics cookies) and third-party cookies (such as the DoubleClick cookie) or other third-party identifiers together to compile data regarding user interactions with ad impressions and other ad service functions as they relate to our website.</p>
                                </p>
                                <p>
                                    Opting out:Users can set preferences for how Google advertises to you using the Google Ad Settings page. Alternatively, you can opt out by visiting the Network Advertising Initiative Opt Out page or by using the Google Analytics Opt Out Browser add on.
                                    <br/>
                                    California Online Privacy Protection Act
                                    <br/>
                                    CalOPPA is the first state law in the nation to require commercial websites and online services to post a privacy policy. The law's reach stretches well beyond California to require any person or company in the United States (and conceivably the world) that operates websites collecting Personally Identifiable Information from California consumers to post a conspicuous privacy policy on its website stating exactly the information being collected and those individuals or companies with whom it is being shared. - See more at: <a href="http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf"> http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf</a>
                                    <br/>
                                    According to CalOPPA, we agree to the following:
                                    <br/>
                                    Users can visit our site anonymously.
                                    <br/>
                                    Once this privacy policy is created, we will add a link to it on our home page or as a minimum, on the first significant page after entering our website.
                                    <br/>
                                    Our Privacy Policy link includes the word 'Privacy' and can easily be found on the page specified above.
                                    <br/>
                                    You will be notified of any Privacy Policy changes:
                                    <br/>
                                    • On our Privacy Policy Page
                                    <br/>
                                    Can change your personal information:
                                    <br/>
                                    • By logging in to your account
                                    <br/>
                                    How does our site handle Do Not Track signals?<br/>
                                    We honor Do Not Track signals and Do Not Track, plant cookies, or use advertising when a Do Not Track (DNT) browser mechanism is in place.
                                    Does our site allow third-party behavioral tracking? <br/>
                                    It's also important to note that we allow third-party behavioral tracking<br/>
                                    COPPA (Children Online Privacy Protection Act) <br/>

                                    When it comes to the collection of personal information from children under the age of 13 years old, the Children's Online Privacy Protection Act (COPPA) puts parents in control. The Federal Trade Commission, United States' consumer protection agency, enforces the COPPA Rule, which spells out what operators of websites and online services must do to protect children's privacy and safety online.<br/>
                                    We do not specifically market to children under the age of 13 years old.<br/>

                                    Fair Information Practices<br/>

                                    The Fair Information Practices Principles form the backbone of privacy law in the United States and the concepts they include have played a significant role in the development of data protection laws around the globe. Understanding the Fair Information Practice Principles and how they should be implemented is critical to comply with the various privacy laws that protect personal information.<br/>
                                    In order to be in line with Fair Information Practices we will take the following responsive action, should a data breach occur:<br/>
                                    • Within 7 business days<br/>
                                    We will notify the users via in-site notification<br/>
                                    • Within 7 business days<br/>

                                    We also agree to the Individual Redress Principle which requires that individuals have the right to legally pursue enforceable rights against data collectors and processors who fail to adhere to the law. This principle requires not only that individuals have enforceable rights against data users, but also that individuals have recourse to courts or government agencies to investigate and/or prosecute non-compliance by data processors.<br/>

                                    CAN SPAM Act<br/>

                                    The CAN-SPAM Act is a law that sets the rules for commercial email, establishes requirements for commercial messages, gives recipients the right to have emails stopped from being sent to them, and spells out tough penalties for violations.<br/>
                                    We collect your email address in order to:
                                    <ul>
                                        <li>Send information, respond to inquiries, and/or other requests or questions</li>
                                        <li>Process orders and to send information and updates pertaining to orders.</li>
                                        <li>Send you additional information related to your product and/or service</li>
                                        <li>Market to our mailing list or continue to send emails to our clients after the original transaction has occurred.</li>
                                    </ul>
                                    To be in accordance with CANSPAM, we agree to the following:
                                    <ul>
                                        <li>Not use false or misleading subjects or email addresses.</li>
                                        <li>Identify the message as an advertisement in some reasonable way.</li>
                                        <li>Include the physical address of our business or site headquarters.</li>
                                        <li>Monitor third-party email marketing services for compliance, if one is used.</li>
                                        <li>Honor opt-out/unsubscribe requests quickly.</li>
                                        <li>Allow users to unsubscribe by using the link at the bottom of each email.</li>
                                    </ul>
                                </p>
                            </div>
                            <div class="col-sm-12">
                            <div class="group-title-index">
                                <h1>Contacting Us</h1>
                            </div>
                            <div class="">
                                If there are any questions regarding this privacy policy, you may contact us using the information below.
                                <address>
                                    <a href="http://www.gotouniversity.com">www.gotouniversity.com</a><br/>
                                    1606 Al Attar Towers<br/>
                                    Dubai, Dubai 116009<br/>
                                    UAE<br/>
                                    <a href="mailto:info@gotouniversity.com">info@gotouniversity.com</a>

                                </address>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
