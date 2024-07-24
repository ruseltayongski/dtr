<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flexbox Debugging</title>
    <style>
        .container {
            width: 100%;
            height: 100px;
        }
        .item {
            display: inline-block;
            flex: 1;
            width: 49%;
            color: black;
            text-align: justify;
            font-size: 10.5px;
            font-family: "Helvetica Neue", sans-serif;
        }
        .item2 {
            display: inline-block;
            flex: 1;
            float: right;
            color: black;
            text-align: justify;
            width: 48%;
            margin-left: 15px;
            font-size: 10.5px;
            font-family: "Helvetica Neue", sans-serif;
        }
        .bottom{
            font-family: "Helvetica Neue", sans-serif;
            font-size: 10.5px;
        }
    </style>
</head><body>
<div>
    <div style="width: 100%; height: 30px; border: 1px solid black; font-size: 15px; text-align:center; margin-bottom: 10px;margin-top: 35px">
        <p style="margin-top: 5px"> INSTRUCTIONS AND REQUIREMENTS</p>
    </div>
</div>
<div class="container">
    <div class="item">
        <p style="margin-top: 1px;">Application for any type of leave shall be made on this Form and <b style="text-decoration:underline">to be</b><b style="text-decoration:underline">accomplished at least in duplicate</b> with documentary requirements, as follows:</p>
        <b>1. Vacation leave*</b>
        <p style="margin-left: 15px; margin-top: 2px">
            It shall be filed five (5) days in advance, whenever possible, of the effective date of such leave. Vacation leave within in he Philippines or
            abroad shall be indicated in the form for purposes of such securing travel authority and completing clearance from money and work accountabilities.
        </p>
        <b>2. Mandatory/Forced leave</b>
        <p style="margin-left: 15px; margin-top: 2px">
            Annual five-day vacation leave shall be forfeited if not taken during the year. In case the scheduled leave has been cancelled in the exigency
            of the service by the head of agency, it shall no longer be deducted from the accumulated vacation leave. Availment of one (1) day or more Vacation
            Leave (VL) shall be considered for complying the mandatory/forced leave subject to the conditions under Section 25, Rule  XVI of the Omnibus Rules
            Implementing E.O No. 292.
        </p>
        <b>3. Sick leave*</b>
        <p style="margin-left: 15px; margin-top: 2px">
            <b>&bull;</b> It shall be filed immediately upon employee's return from such leave.<br>
            <b>&bull;</b> If filed in advance or exceeding five (5) days, application shall be accompanied by a <u>medical certificate</u>. In case medical
            consultation was not availed of, an <u>affidavit</u> should be executed by an applicant.
        </p>
        <b>4. Maternity leave* - 105 days</b>
        <p style="margin-left: 15px; margin-top: 2px">
            <b>&bull;</b> Proof of pregnancy e.g. ultrasound, doctor's certificate on the expected date of delivery.<br>
            <b>&bull;</b> Accomplished Notice of Allocation of Maternity Leave Credits (CS Form No. 6a), if needed.
            <b>&bull;</b> Seconded female employees shall enjoy maternity leave with full pay in the recipient agency.
        </p>
        <b>5. Paternity leave - 7 days</b>
        <p style="margin-left: 15px; margin-top: 2px">
            Proof of child's delivery e.g. birth certificate, medical certificate and marriage contract.
        </p>
        <b>6. Special Privilege leave - 3 days</b>
        <p style="margin-left: 15px; margin-top: 2px">
            It shall be filed/approved for at least one (1) week prior to availment, except on emergency cases. Special privilege leave within the Philippines or
            abroad shall be indicated in the form from money and work accountabilities.
        </p>
        <b>7. Solo Parent leave - 7 days</b>
        <p style="margin-left: 15px; margin-top: 2px">
            It shall be filed in advance of whenevr possible five (5) days before going such leave with updated Solo Parent Identification Card.
        </p>
        <b>8. Study leave* - up to 6 months</b>
        <p style="margin-left: 15px; margin-top: 2px">
            <b>&bull;</b> Shall meet the agency's internal requirements, if any;<br>
            <b>&bull;</b> Contract between the agency head or authorized representative and employee concerned.
        </p>
        <b>9. VAWC leave - 10 days</b>
        <p style="margin-left: 15px; margin-top: 2px">
            <b>&bull;</b> It shall be filed in advance or immediately upon the woman employee's return from such leave.<br>
            <b>&bull;</b> It shall be accompanied by any of the following supporting documents:
        </p>
        <p style="margin-left: 25px; margin-top: 2px">
            a.Barangay Protection Order (BPO) obtained from the barangay;<br>
            b.Temporary/Permanent Protection Order (TPO/PPO) obtained from the court;<br>
            c.If the protection order is not yet issued by the barangay or the court, a certification issued by the Punong Barangay/Kagawad or
            Prosecuter or the Clerk of Court that the application for the BPO,
        </p>
    </div>
    <div class="item2">
        <p style="margin-left: 25px; margin-top: 2px">
            TPO or PPO has been filed with the said office shall be sufficient to support the application for the ten-day leave; or<br>
            d. In the absence of the BPO/TPO/PPO or the certification, a police report specifying the details of the occurrence of
            violence on the victim and a medical certificate may be considered, at the discretion of the immediate supervisor of the
            woman employee concerned.
        </p>
        <b>10. Rehabilitation leave* - up to 6 months</b>
        <p style="margin-left: 15px; margin-top: 2px">
            <b>&bull;</b> Application shall be made within one (1) week from the time of the accident except when a longer period is warranted.<br>
            <b>&bull;</b> Letter request supported by relevant reports such as the police report, if any,<br>
            <b>&bull;</b> Medical certificate on the nature of the injuries, the course of treatment involved, and the need to undergo rest, recuperation,
            and rehabilitation, as the case may be.<br>
            <b>&bull;</b> Written concurrence of a government physician should be obtained relative to the recommendation for the rehabilitation
            if the attending physician is a private practitioner, particularly on the duration of the period of rehabilitation.<br>
        </p>
        <b>11. Special leave benefits for women* - up to 2 months</b>
        <p style="margin-left: 15px; margin-top: 2px">
            <b>&bull;</b> The application may be filed in advance, that is, at least five (5) days prior to the scheduled date of the gynecological surgery
            that will be undergone by the employee. In case of emergency, the application for special leave shall be filed immediately upon the employee's
            return but during the confinement the agency shall be notified of said surgery.<br>
            <b>&bull;</b> The application shall be accompanied by a medical certificate filled out by the proper medical authorities, e.g. the attending
            surgeon accompanied by a clinical summary reflecting the gynecological disorder which shall be addressed or was addressed by the said surgery;
            the histopathological report; the operative technique used for the surgery; the duration of the surgery including the perioperative period
            (period of confinement around surgery); as well as the employees estimated period of recuperation for the same.
        </p>
        <b>12. Special Emergency (Calamity) leave - up to 5 days</b>
        <p style="margin-left: 15px; margin-top: 2px">
            <b>&bull;</b> The special emergency leave can be applied for a maximum of five (5) straight working days or staggered basis within thirty (30)
            days from the actual occurence of the natural calamity/. Said privilege shall be enjoyed once a year, not in every instance of calamity or
            disaster.<br>
            <b>&bull;</b> The head of office shall take full responsibility for the grant of special emergency leave and verification of the employee's
            eligibility to be granted thereof. Said verification shall include: validation of place of residence based on latest available records of the
            affected employee; verification that the place of residence is covered in the declaration of calamity area by the proper government agency;
            and such other proofs as may be necessary.
        </p>
        <b>13. Monetization of leave credits</b>
        <p style="margin-left: 15px; margin-top: 2px">
            Application for monetization of fifty percent (50%) or more of the accumulated leave credits shall be accompanied by letter request to the head
            of the agency stating the valid and justifiable reasons.
        </p>
        <b>14. Terminal leave*</b>
        <p style="margin-left: 15px; margin-top: 2px">
            Proof of employee's resignation or retirement or separation from the service.
        </p>
        <b>15. Adoption Leave</b>
        <p style="margin-left: 15px; margin-top: 2px">
            <b>&bull;</b> Application for adoption leave shall be filed with an authenticated copy of the Pre-Adoptive Placement Authority issued by the
            Department of Social Welfare and Development (DSWD).
        </p>
    </div>
    <p class="bottom">
        ____________________________________<br><br>
        &bull; For leave of absence for thirty (30) calendar days or more and terminal leave, application shall be accompanied by a
        <u>clearance from money, property and work-related accountabilities</u> (pursuant to CSC Memorandum Circular No. 2, s. 1985).
    </p>
</div>
</body></html>
