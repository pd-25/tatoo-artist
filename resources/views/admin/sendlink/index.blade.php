<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TATTOO INFORMED CONSENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('admin-asset/getlink/style.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .display-none {
            display: none;
        }

        #signaturePad {
        height: 200px; /* Fixed height for both views */
        border: 1px solid #000; /* Optional: Add a border for visibility */
        display: block; /* Ensures the canvas is displayed as a block element */
        margin: 0 auto; /* Center the canvas */
    }

    /* Desktop view styles */
    @media (min-width: 768px) { /* Adjust breakpoint as needed */
        #signaturePad {
            width: 400px; /* Fixed width for desktop view */
            padding: 0px;
            margin: 0;
        }
    }

    /* Mobile view styles */
    @media (max-width: 767px) { /* Adjust breakpoint as needed */
        #signaturePad {
            width: 100%; /* Auto width for mobile view to take full container width */
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="container">
                    <h5 class="text-center">TATTOO INFORMED CONSENT & MEDICAL HISTORY</h5>
                    <h5 class="text-center">{{$artistinfo->name}}</h5>
                    <h5 class="text-center">{{$artistinfo->address ?? '!Address not found' }}</h5>
                    <hr class="lin" />
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row text-justify">
            <p>
                I am signing this agreement to induce {{$artistinfo->name ?? '!name not found' }} and the Subcontracted Tattoo Artist
                (STA) to modify my tattoo and/or tattoo my person. In consideration of doing so, I hereby release {{$artistinfo->name ?? '!name not found' }} and
                its
                employees and agents from all manner of liabilities, claims, actions and demands in law or in equity
                which I or my heirs have or might have now or hereafter by reason of complying with my request to be
                tattooed.
            </p>
            <p>
                I am promising to disclose on this medical form and to my STA if I have any of the following conditions,
                including but not limited to, a history or Herpes Infection at the proposed procedure site, Diabetes,
                Allergic
                reactions to latex or antibiotics, Hemophilia or other bleeding disorders, or Cardiac Vascular Disease,
                Epilepsy, Keloiding (excessive scarring), AIDS or HIV, AIDS Related Complex (ARC), under the influence
                of drugs or
                alcohol, and Swelling, Lumps, or signs of irritation of the area to be tattooed or any related health
                risks. I will disclose if I am currently using medication, including being prescribed antibiotics prior
                to dental or
                surgical procedures. Additionally, I will share if other risk factors for bloodborne pathogen exposure
                exist in my daily life. To my knowledge I do not have any physical, mental, or medical impairments or
                disability
                which might affect my well being as a direct or indirect result from my decision to have tattoo work
                done at this time. Some of these conditions include pregnancy and but not limed to a history of severe
                asthma attacks
            </p>
            <p>
                The procedure of getting a tattoo means the insertion of pigment in human skin tissue by piercing it
                with a needle. It is permanent. I am aware that tattooing is a hazardous activity, and am voluntarily
                participating
                with knowledge of the risks involved, which include infection or other injury. I understand it can be
                expensive and painful to remove a tattoo and that the process is not always successful and may result in
                scarring.
                Additional information regarding this procedure are furnished in {{$artistinfo->name ?? '!name not found' }}'s Post Procedure Instructions. With
                full knowledge of the dangers and risks involved I hereby agree and accept all risks of any kind or
                nature. Being
                of sound mind and body, I hereby release any and all persons representing {{$artistinfo->name ?? '!name not found' }} from all responsibility
                and liability for any consequences
            </p>
            <p>
                that may stem from my decision to have tattoo work done. I hereby agree to hold harmless all owners,
                agents, employees, and representatives of {{$artistinfo->name ?? '!name not found' }}. I further agree not to file any suit, claim, or action
                for any damages,
                demands, rights, or causes of action for any nature, including but not limited to injury, maiming,
                property damage or death to myself or any other person arising from my decision to have tattoo work done
                by {{$artistinfo->name ?? '!name not found' }}, its
                owners, agents, employees or representatives harmless of all damages, actions, causes of action, claim
                judgements, cost of litigation, attorney fees, and any and all costs and expenses which may arise from
                my decision to
                have tattoo work done by {{$artistinfo->name ?? '!name not found' }}
            </p>
            <p>
                I agree to leave the premises of {{$artistinfo->name ?? '!name not found' }} promptly upon request by any owner, agent, employee, or
                representative of {{$artistinfo->name ?? '!name not found' }} for any reason whatsoever. I agree these waivers and releases pertain to and are
                directed to protect {{$artistinfo->name ?? '!name not found' }}.
            </p>
        </div>
    </div>

    <form action="{{ route('admin.userformsubmit') }}" name="userform" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <input type="hidden" name="artist_id" value="{{ $artist_id }}">
        <input type="hidden" name="dbid" value="{{ $dbid }}">

        <div class="container">

            <div class="row">
                <p class="text-center">The FDA has not approved the use of any tattoo ink.</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="container">
                        <h5>MEDICAL HISTORY</h5>
                        <hr class="dotted" />
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Are you in general good health at this time?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="general_good_health" value="1" checked required />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="general_good_health" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Are you under any medical treatment now?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="you_under_any_medical_treatment" value="1" checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="you_under_any_medical_treatment" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Are you currently taking any drugs or medications?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="you_currently_taking_any_drugs" value="1" checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="you_currently_taking_any_drugs" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Do you have a history of medication use?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="you_have_a_history_of_medication" value="1" checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="you_have_a_history_of_medication" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Do you have a history of fainting?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="you_have_a_history_of_fainting" value="1" checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="you_have_a_history_of_fainting" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Are you allergic to latex?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="are_you_allergic_to_latex" value="1" checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="are_you_allergic_to_latex" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Have any wounds healed slowly or presented other complications?</p>

                                <p></p>
                            </div>

                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="have_any_wounds_healed_slowly" value="1" checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="have_any_wounds_healed_slowly" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Are you allergic to any know materials or medications (or antibiotics) resulting in
                                    hives, asthma, eczema, etc.?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="are_you_allergic_to_any_know_materials" value="1"
                                        checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="are_you_allergic_to_any_know_materials" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Any risk factors from work or lifestyle, that lead to exposure for bloodborne
                                    pathogens?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="any_risk_factors_from_work_or_lifestyle" value="1"
                                        checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="any_risk_factors_from_work_or_lifestyle" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding-right: 25px;">
                            <div class="col-md-10">
                                <p>Are you pregnant or nursing?</p>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="are_you_pregnant_or_nursing" value="1" checked />
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-1">
                                <label class="radio-container">
                                    <input type="radio" name="are_you_pregnant_or_nursing" value="0" />
                                    <span class="checkmark2"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"></div>
                        </div>
                        <p style="">Any history of or current conditions of: <span style="font-size: 12px;"> (check all
                                the apply)</span></p>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="cardiac_valve_disease" type="checkbox"
                                        value="1" id="1" />
                                    <label class="form-check-label" for="1">
                                        Cardiac Valve Disease
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="high_blood_pressure" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="1">
                                        High Blood Pressure
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="respiratory_disease" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="1">
                                        Respiratory Disease
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="diabetes" type="checkbox" value="1" id="1" />
                                    <label class="form-check-label" for="1">
                                        Diabetes
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="tumors_or_growths" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="1">
                                        Tumors or Growths
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="hemophilia" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="1">
                                        Hemophilia
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="liver_disease" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="1">
                                        Liver Disease
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="bleeding_disorder" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="8">
                                        Bleeding Disorder
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="kidney_disease" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="1">
                                        Kidney Disease
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="epilepsy" type="checkbox" value="1" id="1" />
                                    <label class="form-check-label" for="1">
                                        Epilepsy
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="jaundice" type="checkbox" value="1" id="1" />
                                    <label class="form-check-label" for="1">
                                        Jaundice
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="exposure_to_aids" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="1">
                                        Exposure to AIDS
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="hepatitis" type="checkbox" value="1" id="1" />
                                    <label class="form-check-label" for="1">
                                        Hepatitis
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" name="venereal_disease" type="checkbox" value="1"
                                        id="1" />
                                    <label class="form-check-label" for="1">
                                        Venereal Disease
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-8">
                                <div class="form-check">
                                    <input class="form-check-input" name="herpes_infection_at_proposed_procedure_site"
                                        type="checkbox" value="1" id="1" />
                                    <label class="form-check-label" for="1">
                                        Herpes Infection at Proposed Procedure Site
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="container">
                        <h5 class="uppercase">CLIENT INFORMATION</h5>
                        <hr class="dotted" />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">Name</span>
                                    <input type="text" name="name" class="form-control" id="basic-url"
                                        aria-describedby="basic-addon3" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">Today's Date</span>
                                    <input type="date" name="todaysdate" class="form-control uppercase" id="basic-url"
                                        aria-describedby="basic-addon3" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">Birth Date</span>
                                    <input type="date" name="birthdate" class="form-control uppercase" id="basic-url"
                                        aria-describedby="basic-addon3" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">Phone: (H/W/C)</span>
                                    <input type="text" name="phone" class="form-control" id="phone"
                                        aria-describedby="phoneHelp" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">Address</span>
                                    <textarea class="form-control" name="address" id="exampleFormControlTextarea1"
                                        rows="3" aria-describedby="basic-addon3" placeholder="Street,City,State,ZIP...."
                                        required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">State ID</span>
                                    <input type="text" name="stateid" class="form-control" id="basic-url"
                                        aria-describedby="basic-addon3" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="p-1">
                                    Your signature declares your understanding and agreement of this Informed Consent,
                                    truthfulness in response of your medical history, and acknowledgment of being 18
                                    years of age or older. Additionally,
                                    affirmation that you have received your Post Procedure Instructions and have had
                                    opportunity to have any and all questions regarding the procedure answered.
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="signatureOption" class="form-label">Signature  Type</label>
                                    <select id="signatureOption" class="form-control" onchange="toggleSignatureOptions(this)">
                                        <option value="file">Upload File</option>
                                        <option value="digital">Digital Signature</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- File Upload Input -->
                            <div id="file-input-div" class="mb-3">
                                <label for="formFileSm" class="form-label">Upload Signature</label>
                                <input  class="form-control form-control-sm" name="signature" id="formFileSm" type="file" accept="image/*" onchange="readURL(this, 'sign');" />
                                <img id="sign" src="" class="display-none imgx" alt="your image" style="display: none; max-width: 100%; height: auto;" />
                            </div>
                            
                            <!-- Digital Signature Canvas -->
                            <div id="digital-signature-div" class="form-group" style="display: none;">
                                <label for="digital_signature">Digital Signature (Draw Here)</label>
                                <canvas id="signaturePad" class="border ffffdee"></canvas>
                                <input  type="hidden" id="digital_signature" name="digital_signature">
                                <button type="button" class="btn btn-secondary mt-2" id="clearSignature">Clear Signature</button>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="formFileSm" class="form-label">Driving Licence Front</label>
                                    <input required class="form-control form-control-sm" name="driving_licence_front"
                                        id="formFileSm" type="file" accept="image/*"
                                        onchange="readURL(this,'dl-front');" />
                                    <img id="dl-front" src="" class="display-none imgx" alt="your image" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="formFileSm" class="form-label">Driving Licence Back</label>
                                    <input required class="form-control form-control-sm" name="driving_licence_back"
                                        id="formFileSm" type="file" accept="image/*"
                                        onchange="readURL(this,'dl-back');" />
                                    <img id="dl-back" src="" class="display-none imgx" alt="your image" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5 col-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

            <div class="row mt-5">
                <p class="text-center">This intellectual property belongs to the owner of {{$artistinfo->name ?? '!name not found' }} and may not be copied
                    without written consent from the author.</p>
            </div>
        </div>

    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#phone').mask('+000 000-0000', {
                'translation': {
                    0: { pattern: /[0-9]/ }
                }
            });
        });
    </script>
</body>

</html>

<script>
    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#" + id).attr("src", e.target.result);
                $("#" + id).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
    // Initialize the canvas for digital signature
    const canvas = document.getElementById('signaturePad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    // Helper function to get the correct position
    function getPosition(e) {
        const rect = canvas.getBoundingClientRect();
        if (e.touches) {  // Touch events
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            };
        } else {  // Mouse events
            return {
                x: e.offsetX,
                y: e.offsetY
            };
        }
    }

    // Start drawing
    function startDrawing(e) {
        e.preventDefault();  // Prevent scrolling on touch devices
        drawing = true;
        const pos = getPosition(e);
        ctx.moveTo(pos.x, pos.y);
    }

    // Draw on the canvas
    function draw(e) {
        if (!drawing) return;
        const pos = getPosition(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
    }

    // Stop drawing
    function stopDrawing() {
        drawing = false;
        updateSignatureInput();
    }

    // Mouse events
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Touch events
    canvas.addEventListener('touchstart', startDrawing);
    canvas.addEventListener('touchmove', draw);
    canvas.addEventListener('touchend', stopDrawing);
    canvas.addEventListener('touchcancel', stopDrawing);

    // Clear the signature pad
    document.getElementById('clearSignature').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas
        ctx.beginPath(); // Reset the current drawing path
        updateSignatureInput(); // Update the hidden input
    });

    // Update hidden input with the base64 image data
    function updateSignatureInput() {
        const signatureInput = document.getElementById('digital_signature');
        signatureInput.value = canvas.toDataURL('image/png');
    }

    // Handle form submission for digital signature or file upload
    document.getElementById('tattooForm').addEventListener('submit', function (e) {
        const signatureFileInput = document.getElementById('formFileSm').files[0];
        const digitalSignatureInput = document.getElementById('digital_signature').value;

        if (!signatureFileInput && !digitalSignatureInput) {
            e.preventDefault();
            alert('Please provide either a signature file or draw a digital signature.');
        }
    });

    // Toggle between signature file upload and digital signature drawing
    function toggleSignatureOptions(select) {
        const fileInputDiv = document.getElementById('file-input-div');
        const digitalSignatureDiv = document.getElementById('digital-signature-div');
        const fileInput = document.getElementById('formFileSm');  // Corrected File input field ID
        const digitalSignatureInput = document.getElementById('digital_signature');  // Hidden input for digital signature

        if (select.value === 'file') {
            // Show file input and hide digital signature drawing area
            fileInputDiv.style.display = 'block';
            digitalSignatureDiv.style.display = 'none';

            // Make file input required and remove the requirement from digital signature
            fileInput.setAttribute('required', 'required');
            digitalSignatureInput.removeAttribute('required');
        } else if (select.value === 'digital') {
            // Show digital signature drawing area and hide file input
            fileInputDiv.style.display = 'none';
            digitalSignatureDiv.style.display = 'block';

            // Make digital signature required and remove the requirement from file input
            digitalSignatureInput.setAttribute('required', 'required');
            fileInput.removeAttribute('required');
        }
    }

    // Set initial state
    document.addEventListener('DOMContentLoaded', function () {
        toggleSignatureOptions(document.getElementById('signatureOption'));
    });
</script>


