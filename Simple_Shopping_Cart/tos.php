<?php

include 'db_connect.php';

session_start();
$pdo = pdo_connect_mysql();

$search = $_GET['search'] ?? '';
$search_sql = $search ? 'WHERE(name LIKE "%":search"%") ': '';
$stmt = $pdo->prepare('SELECT * FROM products '.$search_sql.'');
if($search) $stmt->bindParam(':search', $search, PDO::PARAM_STR);
$stmt->execute();
$products =$stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$page_title = "Shopping Cart";
include 'theme_components/head.php';
include 'theme_components/topNav.php';
include 'theme_components/login-Reg-modal.php';
include 'theme_components/mobile-accordion.php';
?>
<div class="container-sm">
          <p class="TERMSCodiTitle"> TERMS AND CONDITIONS </p>
          
          <p class="TermsCondiContent"> 
            In using this website you are deemed to have read and agreed to the following terms and conditions: <br/> <br/> 
            The following terminology applies to these Terms and Conditions, 
            Privacy Statement and Disclaimer Notice and any or all Agreements: 
            "Client", “You” and “Your” refers to you, the person accessing this website and 
            accepting the Company’s terms and conditions. 
            "The Company", “Ourselves”, "B&C", "Beauty & Carts", “We” and "Us", refers to our Company. 
            “Party”, “Parties”, or “Us”, refers to both the Client and ourselves, 
            or either the Client or ourselves. <br/> All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner, whether by formal meetings of a fixed duration, or any other means, for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services/products, in accordance with and subject to, prevailing English Law. Any use of the above terminology or other words in the singular, plural, capitalisation and/or he/she or they, are taken as interchangeable and therefore as referring to same.
            to customers located in those geographic regions, or as required by applicable laws.
          </p>
          
          <p class="TermsCondiContent">   PRIVACY STATEMENT </p>
          <p class="TermsCondiContent">  
            We are committed to protecting your privacy. Authorized employees within the company on a need to know basis only use any information collected from individual customers. We constantly review our systems and data to ensure the best possible service to our customers. Parliament has created specific offences for unauthorised actions against computer systems and data. We will investigate any such actions with a view to prosecuting and/or taking civil proceedings to recover damages against those responsible
          </p>

          <p class="TERMSCodiTitle"> CONFIDENTIALITY  </p>
          <p class="TermsCondiContent">  
            We are registered under the Data Privacy Act of 2012 and as such,
            any information concerning the Client and their respective Client 
            Records may be passed to third parties. However, Client records are regarded 
            as confidential and therefore will not be divulged to any third party,
            other than YAPS INC.
            if legally required to do so to the appropriate authorities. 
            Clients have the right to request sight of, and copies of any and
             all Client Records we keep, on the proviso that we are given 
             reasonable notice of such a request. Clients are requested to retain copies of 
             any literature issued in relation to the provision of our services. 
             Where appropriate, we shall issue Client’s with appropriate written information, 
             handouts or copies of records as part of an agreed contract, 
             for the benefit of both parties.

             <strong><br/>We will not sell, share, or rent your personal information to any third party or use your e-mail address for unsolicited mail. Any emails sent by this Company will only be in connection with the provision of agreed services and products. </strong>
          </p> 

          <p class="TERMSCodiTitle"> SECTION 1 - ONLINE STORE ITEMS  </p>
          <p class="TermsCondiContent"> 
            By agreeing to these Terms AND conditions, you represent that you are at least the age of majority in your state or province of residence, or that you are the age of majority in your state or province of residence and you have given us your consent to allow any of your minor dependents to use this site.
You may not use our products for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws).
You must not transmit any worms or viruses or any code of a destructive nature.
A breach or violation of any of the Terms will result in an immediate termination of your Services.
            </p>

            <p class="TERMSCodiTitle"> SECTION 2 -  GENERAL CONDITIONS  </p>
            <p class="TermsCondiContent"> 
            We reserve the right to refuse service to anyone for any reason at any time.
You understand that your content (not including credit card information), may be transferred unencrypted and involve (a) transmissions over various networks; and (b) changes to conform and adapt to technical requirements of connecting networks or devices. Credit card information is always encrypted during transfer over networks.
You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service or any contact on the website through which the service is provided, without express written permission by us.
The headings used in this agreement are included for convenience only and will not limit or otherwise affect these Terms.
            </p>

            <p class="TERMSCodiTitle"> SECTION 3 -  ACCURACY, COMPLETENESS AND TIMELINESS OF INFORMATION </p>
            <p class="TermsCondiContent"> 
            We are not responsible if information made available on this site is not accurate, complete or current. The material on this site is provided for general information only and should not be relied upon or used as the sole basis for making decisions without consulting primary, more accurate, more complete or more timely sources of information. Any reliance on the material on this site is at your own risk.
This site may contain certain historical information. Historical information, necessarily, is not current and is provided for your reference only. We reserve the right to modify the contents of this site at any time, but we have no obligation to update any information on our site. You agree that it is your responsibility to monitor changes to our site.
            </p>
            
            <p class="TERMSCodiTitle"> SECTION 4 -  MODIFICATIONS TO THE SERVICE AND PRICES </p>
            <p class="TermsCondiContent"> 
              Prices for our products are subject to change without notice.
              We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice at any time. <br/> 
              We shall not be liable to you or to any third-party for any modification, price change, suspension or discontinuance of the Service.
            </p>
            
            <p class="TERMSCodiTitle"> SECTION 5 -  PRODUCTS OR SERVICES (if applicable) </p>
            <p class="TermsCondiContent"> 
              Certain products or services may be available exclusively online through the website. These products or services may have limited quantities and are subject to return or exchange only according to our Return Policy.
              We have made every effort to display as accurately as possible the colors and images of our products that appear at the store. We cannot guarantee that your computer monitor's display of any color will be accurate.
              We reserve the right, but are not obligated, to limit the sales of our products or Services to any person, geographic region or jurisdiction. We may exercise this right on a case-by-case basis. We reserve the right to limit the quantities of any products or services that we offer. All descriptions of products or product pricing are subject to change at anytime without notice, at the sole discretion of us. We reserve the right to discontinue any product at any time. Any offer for any product or service made on this site is void where prohibited.
              We do not warrant that the quality of any products, services, information, or other material purchased or obtained by you will meet your expectations, or that any errors in the Service will be corrected.
            </p>

            <p class="TERMSCodiTitle"> SECTION 6 - ACCURACY OF BILLING AND ACCOUNT INFORMATION </p>
            <p class="TermsCondiContent"> 
              We reserve the right to refuse any order you place with us. We may, in our sole discretion, limit or cancel quantities purchased per person, per household or per order. These restrictions may include orders placed by or under the same customer account, the same credit card, and/or orders that use the same billing and/or shipping address. In the event that we make a change to or cancel an order, we may attempt to notify you by contacting the e‑mail and/or billing address/phone number provided at the time the order was made. We reserve the right to limit or prohibit orders that, in our sole judgment, appear to be placed by dealers, resellers or distributors.
              You agree to provide current, complete and accurate purchase and account information for all purchases made at our store. You agree to promptly update your account and other information, including your email address and credit card numbers and expiration dates, so that we can complete your transactions and contact you as needed.
              For more detail, please review our Returns Policy.
            </p>

            <p class="TERMSCodiTitle"> SECTION 7 - OPTIONAL TOOLS</p>
            <p class="TermsCondiContent"> 
              We may provide you with access to third-party tools over which we neither monitor nor have any control nor input.
You acknowledge and agree that we provide access to such tools ”as is” and “as available” without any warranties, representations or conditions of any kind and without any endorsement. We shall have no liability whatsoever arising from or relating to your use of optional third-party tools.
Any use by you of optional tools offered through the site is entirely at your own risk and discretion and you should ensure that you are familiar with and approve of the terms on which tools are provided by the relevant third-party provider(s).
We may also, in the future, offer new services and/or features through the website (including, the release of new tools and resources). Such new features and/or services shall also be subject to these Terms of Service.
            </p>

            <p class="TERMSCodiTitle"> SECTION 8 - THIRD-PARTY LINKS </p>
            <p class="TermsCondiContent"> 
              Certain content, products and services available via our Service may include materials from third-parties.
              Third-party links on this site may direct you to third-party websites that are not affiliated with us. We are not responsible for examining or evaluating the content or accuracy and we do not warrant and will not have any liability or responsibility for any third-party materials or websites, or for any other materials, products, or services of third-parties.
              <br/>  We are not liable for any harm or damages related to the purchase or use of goods, services, resources, content, or any other transactions made in connection with any third-party websites. Please review carefully the third-party's policies and practices and make sure you understand them before you engage in any transaction. Complaints, claims, concerns, or questions regarding third-party products should be directed to the third-party.
            </p>

            <p class="TERMSCodiTitle"> SECTION 9 - USER COMMENTS, FEEDBACK AND OTHER SUBMISSIONS</p>
            <p class="TermsCondiContent"> 
              If, at our request, you send certain specific submissions (for example contest entries) or without a request from us you send creative ideas, suggestions, proposals, plans, or other materials, whether online, by email, by postal mail, or otherwise (collectively, 'comments'), you agree that we may, at any time, without restriction, edit, copy, publish, distribute, translate and otherwise use in any medium any comments that you forward to us. We are and shall be under no obligation (1) to maintain any comments in confidence; (2) to pay compensation for any comments; or (3) to respond to any comments.
              <br/>  
              We may, but have no obligation to, monitor, edit or remove content that we determine in our sole discretion are unlawful, offensive, threatening, libelous,
               defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms and Conditions.
               <br/> 
               You agree that your comments will not violate any right of any third-party, including copyright, trademark, privacy, personality or other personal or proprietary right. You further agree that your comments will not contain libelous or otherwise unlawful, abusive or obscene material, or contain any computer virus or other malware that could in any way affect the operation of the Service or any related website. You may not use a false e‑mail address, pretend to be someone other than yourself, or otherwise mislead us or third-parties as to the origin of any comments. You are solely responsible for any comments you make and their accuracy. We take no responsibility and assume no liability for any comments posted by you or any third-party.
              </p>
            
              <p class="TERMSCodiTitle"> SECTION 10 - PERSONAL INFORMATION</p>
              <p class="TermsCondiContent"> 
              Your submission of personal information through the store is governed by our Privacy Policy. To view our Privacy Policy.
              <br/>  
              We may, but have no obligation to, monitor, edit or remove content that we determine in our sole discretion are unlawful, offensive, threatening, libelous,
               defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms and Conditions.
               <br/> 
               You agree that your comments will not violate any right of any third-party, including copyright, trademark, privacy, personality or other personal or proprietary right. You further agree that your comments will not contain libelous or otherwise unlawful, abusive or obscene material, or contain any computer virus or other malware that could in any way affect the operation of the Service or any related website. You may not use a false e‑mail address, pretend to be someone other than yourself, or otherwise mislead us or third-parties as to the origin of any comments. You are solely responsible for any comments you make and their accuracy. We take no responsibility and assume no liability for any comments posted by you or any third-party.
              </p>

              <p class="TERMSCodiTitle"> SECTION 11 - ERRORS, INACCURACIES AND OMISSIONS</p>
              <p class="TermsCondiContent"> 
                Occasionally there may be information on our site or in the Service that contains typographical errors, inaccuracies or omissions that may relate to product descriptions, pricing, promotions, offers, product shipping charges, transit times and availability. We reserve the right to correct any errors, inaccuracies or omissions, and to change or update information or cancel orders if any information in the Service or on any related website is inaccurate at any time without prior notice (including after you have submitted your order).
              <br/>  
              We may, but have no obligation to, monitor, edit or remove content that we determine in our sole discretion are unlawful, offensive, threatening, libelous,
               defamatory, pornographic, obscene or otherwise objectionable or violates any party’s intellectual property or these Terms and Conditions.
               <br/> 
               We undertake no obligation to update, amend or clarify information in the Service or on any related website, including without limitation, pricing information, except as required by law. No specified update or refresh date applied in the Service or on any related website, should be taken to indicate that all information in the Service or on any related website has been modified or updated.
              </p>

              <p class="TERMSCodiTitle"> SECTION 12 - PROHIBITED USES </p>
              <p class="TermsCondiContent"> 
                In addition to other prohibitions as set forth in the Terms of Service, you are prohibited from using the site or its content: (a) for any unlawful purpose; (b) to solicit others to perform or participate in any unlawful acts; (c) to violate any international, federal, provincial or state regulations, rules, laws, or local ordinances; (d) to infringe upon or violate our intellectual property rights or the intellectual property rights of others; (e) to harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability; (f) to submit false or misleading information; (g) to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Service or of any related website, other websites, or the Internet; (h) to collect or track the personal information of others; (i) to spam, phish, pharm, pretext, spider, crawl, or scrape; (j) for any obscene or immoral purpose; or (k) to interfere with or circumvent the security features of the Service or any related website, other websites, or the Internet. We reserve the right to terminate your use of the Service or any related website for violating any of the prohibited uses.
              </p>

              <p class="TERMSCodiTitle"> SECTION 13 - INDEMNIFICATION </p>
              <p class="TermsCondiContent"> 
                You agree to indemnify, defend and hold harmless Beauty & Cart and our parent, subsidiaries, affiliates, partners, officers, directors, agents, contractors, licensors, service providers, subcontractors, suppliers, interns and employees, harmless from any claim or demand, including reasonable attorneys’ fees, 
                made by any third-party due to or arising out of your breach of these Terms of Service or the documents they incorporate by reference, or your violation of any law or the rights of a third-party. 
              </p>

              <p class="TERMSCodiTitle"> SECTION 14 - SEVERABILITY </p>
              <p class="TermsCondiContent"> 
                In the event that any provision of these Terms of Service is determined to be unlawful, void or unenforceable, such provision shall nonetheless be enforceable to the fullest extent permitted by applicable law,
                 and the unenforceable portion shall be deemed to be severed from these Terms of Service, such determination shall not affect the validity and enforceability of any other remaining provisions.
              </p>

              <p class="TERMSCodiTitle"> SECTION 15 - TERMINATION </p>
              <p class="TermsCondiContent"> 
                The obligations and liabilities of the parties incurred prior to the termination date shall survive the termination of this agreement for all purposes.
These Terms and Conditions are effective unless and until terminated by either you or us. You may terminate these Terms and Conditions at any time by notifying us that you no longer wish to use our Services, or when you cease using our site.
If in our sole judgment you fail, or we suspect that you have failed, to comply with any term or provision of these Terms of Service, we also may terminate this agreement at any time without notice and you will remain liable for all amounts due up to and including the date of termination; and/or accordingly may deny you access to our Services (or any part thereof).
              </p>

              <p class="TERMSCodiTitle"> SECTION 16 - ENTIRE AGREEMENT </p>
              <p class="TermsCondiContent"> 
                The failure of us to exercise or enforce any right or provision of these Terms of Service shall not constitute a waiver of such right or provision. <br/>
                These Terms of Service and any policies or operating rules posted by us on this site or in respect to The Service constitutes the entire agreement and understanding between you and us and govern your use of the Service, superseding any prior or contemporaneous agreements, communications and proposals, whether oral or written, between you and us (including, but not limited to, any prior versions of the Terms of Service). <br/>
                Any ambiguities in the interpretation of these Terms of Service shall not be construed against the drafting party.
              </p>

              <p class="TERMSCodiTitle"> SECTION 17 -  GOVERNING LAW </p>
              <p class="TermsCondiContent"> 
                These Terms of Service and any separate agreements whereby we provide you Services shall be governed by and construed in accordance with the laws of Philippines.
              </p>

              <p class="TERMSCodiTitle"> SECTION 18 -  CHANGES TO TERMS OF SERVICE</p>
              <p class="TermsCondiContent"> 
                You can review the most current version of the Terms and Conditions at any time at this page.
                We reserve the right, at our sole discretion, to update, change or replace any part of these Terms of Service by posting updates and changes to our website.
                It is your responsibility to check our website periodically for changes. 
                Your continued use of or access to our website or the Service following the posting of any changes to these Terms of Service constitutes acceptance of those changes.
              </p>

              <p class="TERMSCodiTitle"> SECTION 19 -  CONTACT INFORMATION </p>
              <p class="TermsCondiContent"> 
                Questions about the Terms and Conditions should be sent to us at beatyandcarts@Yapsinc.ph
              </p>
          <!-- desclaimer-->

          <p class="TERMSCodiTitle"> DISCLAIMER  </p>
          <p class="TermsCondiContent"> 
            <strong> Exclusions and Limitation </strong> <br/> 
            The information on this web site is provided on an "as is" basis.
             To the fullest extent permitted by law, Beauty & Carts:
             <ul> 
            <li> excludes all representations and warranties relating to this website and its contents or which is or may be provided by any affiliates or any other third party,
               including in relation to any inaccuracies or omissions in this website and/or the Company’s literature; and 
            </li>
            <li> 
              excludes all liability for damages arising out of or in connection with your use of this website. This includes, without limitation, direct loss, loss of business or profits (whether or not the loss of such profits was foreseeable, arose in the normal course of things or you have 
              advised this Company of the possibility of such potential loss), damage caused to your computer, computer software, systems and programs and the data thereon or any other direct or indirect, consequential and incidental damages. 
            </li>
            </ul>            	
            Beauty & Carts does not however exclude liability for death or personal injury caused by its negligence. The above exclusions and limitations apply only to the extent permitted by law. None of your statutory rights as a consumer are affected.             

            <br> <br> 
            <strong> These terms and conditions form part of the Agreement between the Client and ourselves. Your accessing of this website and/or undertaking of a booking or Agreement indicates your understanding, agreement to and acceptance, of the Disclaimer Notice and the full Terms and Conditions contained herein. Your statutory Consumer Rights are unaffected.    </strong>
          </p>
        </div>

        <?php

include 'theme_components/footer.php';

?>