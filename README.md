------------- This extension is created as a test for Compucorp application process and is not ready for production deployment --------
CiviMembershipPeriod Extension
== 

Currently, when a membership is renewed in CiviCRM the “end date” field on the membership itself is extended by the length of the membership as defined in CiviCRM membership type configuration but no record of the actual length of any one period or term is recorded. As such it is not possible to see how many “terms” or “periods” of membership a contact may have had. 

I.e. If a membership commenced on 1 Jan 2014 and each term was of 12 months in length, by 1 Jan 2016 the member would be renewing for their 3rd term. The terms would be:

Term/Period 1: 1 Jan 2014 - 31 Dec 2014
Term/Period 2: 1 Jan 2015 - 31 Dec 2015
Term/Period 3: 1 Jan 2016 - 31 Dec 2016

The aim of this extension is to extend the CiviCRM membership component so that when a membership is created or renewed a record for the membership “period” is recorded. 
 

NEEDED
-- 
* Create some user documentation
  + Supports New Memberships or Membership Renewal
  + Show tracking interface
  + API Supported 


NICE TO HAVE
--

* The aim of this extension is to extend the CiviCRM membership component so that when a membership is created or renewed a record for the membership “period” is recorded.


>>>>>>>>>>> Readme.md <<<<<<<<<<<<<<<
This file outlines what should be witnessed in manual testing (WIP)

1) Membership Term/period Automatic Recorded 

<img src='/docs/images/MembershipPeriod.png'>

<b>Can Be Viewd in Contact [tab] /(Membership Periods)</b>
- When renewing a discount box is visible if the renewal type is eligible for a discount.
- The discount box is visible for all new membership backoffice forms.

<img src='/docs/images/MembershipPeriodTab.png'>
<b>Work with Single Membership Type </b>
- Provided the code is entered and apply When new membership is created or existing membership is renewed
- Clicking 'Save' creates a membership Term/Period with a suitably Start Date and End Date of Membership . 
 

<b>Work with Multi Membership Type </b>
- Provided the code is suitable for multi memberships .
- User can subscribed for 2 different memberships and theres Term/Periods will record and Display
- in Example there's 1 Membership Name " Gold " and 2nd one is " Silver " and user is subscribed with both and display Terms/Period of that  
<img src='/docs/images/MembershipMultiPeriod.png'>
 

2) API Supported 
- This Extension Also Supported Api 
- Created New Entity name " PeriodTrack " 
--- Create / get / Delete / etc....
<img src='/docs/images/MembershipApi.png'>
