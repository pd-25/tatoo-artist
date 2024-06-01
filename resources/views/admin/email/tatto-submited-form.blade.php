<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title></title>
        <link rel="stylesheet" href="style.css" />
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        ></script>
    </head>

    <body>
        <div class="container" style="padding: 20px;">
            <div class="row" style="width: 100vw;">
                <div class="container w100" style="text-align: center;">
                    <h2 class="text-center">TATTOO INFORMED CONSENT & MEDICAL HISTORY</h2>
                    <h2 class="text-center">TRIGGER HAPPY TATTOO, LLC</h2>
                    <h2 class="text-center">704 EAST WHITTIER BLVD., LA HABRA, CA 562.691.8925U</h2>
                    <hr class="lin" />
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

        <div class="text-justify" style="margin: 25px;">
            <p>
                I am signing this agreement to induce Trigger Happy Tattoo, LLC (THT) and the Subcontracted Tattoo Artist (STA) to modify my tattoo and/o tattoo my person. In consideration of doing so, I hereby release THT and its employees
                and agents from all manner of liabilities, claims, actions and demands in law or in equity which I or my heirs have or might have now or hereafter by reason of complying with my request to be tattooed.
            </p>
            <p>
                I am promising to disclose on this medical form and to my STA if I have any of the following conditions, including but not limited to, a history o Herpes Infection at the proposed procedure site, Diabetes, Allergic reactions
                to latex or antibiotics, Hemophilia or other bleeding disorders, o Cardiac Vascular Disease, Epilepsy, Keloiding (excessive scarring), AIDS or HIV, AIDS Related Complex (ARC), under the influence of drugs 01 alcohol, and
                Swelling, Lumps, or signs of irritation of the area to be tattooed or any related health risks. I will disclose if I am currently using medication, including being prescribed antibiotics prior to dental or surgical
                procedures. Additionally, I will share if other risk factors for bloodborne pathogen exposure exist in my daily life. To my knowledge I do not have any physical, mental, or medical impairments or disability which might
                affect my well being as a direct or indirect result from my decision to have tattoo work done at this time. Some of these conditions include pregnancy and but not limed to a history of severe asthma attacks
            </p>
            <p>
                The procedure of getting a tattoo means the insertion of pigment in human skin tissue by piercing it with a needle. It is permanent. I am aware that tattooing is a hazardous activity, and am voluntarily participating with
                knowledge of the risks involved, which include infection or other injury. I understand it can be expensive and painful to remove a tattoo and that the process is not always successful and may result in scarring. Additional
                information regarding this procedure are furnished in THT's Post Procedure Instructions. With full knowledge of the dangers and risks involved I hereby agree and accept all risks of any kind or nature. Being of sound mind
                and body, I hereby release any and all persons representing THT from all responsibility and liability for any consequences
            </p>
            <p>
                that may stem from my decision to have tattoo work done. I hereby agree to hold harmless all owners, agents, employees, and representatives of THT. I further agree not to file any suit, claim, or action for any damages,
                demands, rights, or causes of action for any nature, including but not limited to injury, maiming, property damage or death to myself or any other person arising from my decision to have tattoo work done by THT, its owners,
                agents, employees or representatives harmless of all damages, actions, causes of action, claim judgements, cost of litigation, attorney fees, and any and all costs and expenses which may arise from my decision to have tattoo
                work done by THT
            </p>
            <p>
                I agree to leave the premises of THT promptly upon request by any owner, agent, employee, or representative of THT for any reason whatsoever. I agree these waivers and releases pertain to and are directed to protect THT.
            </p>
        </div>
        <div class="row" style="margin: 25px;">
            <p class="text-center">The FDA has not approved the use of any tattoo ink.</p>
        </div>
        <div class="row">
            <div class="col-md-6" style="width: 100vw; padding: 20px;">
                <h2>MEDICAL HISTORY</h2>
                <hr class="dotted" />
                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10">
                        <p>Are you in general good health at this time? <span style="text-align: end; float: right;">{{ $tattodata->general_good_health == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>
                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10">
                        <p>Are you under any medical treatment now?<span style="text-align: end; float: right;">{{ $tattodata->you_under_any_medical_treatment == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>
                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10 w90">
                        <p>Are you currently taking any drugs or medications? <span style="text-align: end; float: right;">{{ $tattodata->you_currently_taking_any_drugs == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>

                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10 w90">
                        <p>Do you have a history of medication use? <span style="text-align: end; float: right;">{{ $tattodata->you_have_a_history_of_medication == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>

                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10 w90">
                        <p>Do you have a history of fainting? <span style="text-align: end; float: right;">{{ $tattodata->you_have_a_history_of_fainting == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>
                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10 w90">
                        <p>Are you allergic to latex? <span style="text-align: end; float: right;">{{ $tattodata->are_you_allergic_to_latex == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>
                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10 w90">
                        <p>Have any wounds healed slowly or presented other complications? <span style="text-align: end; float: right;">{{ $tattodata->have_any_wounds_healed_slowly == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>
                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10 w90">
                        <p>Are you allergic to any know materials or medications (or antibiotics) resulting in hives, asthma, eczema, etc.? <span style="text-align: end; float: right;">{{ $tattodata->are_you_allergic_to_any_know_materials == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>

                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10 w90">
                        <p>Any risk factors from work or lifestyle, that lead to exposure for bloodborne pathogens? <span style="text-align: end; float: right;">{{ $tattodata->any_risk_factors_from_work_or_lifestyle == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>
                <div class="row w100" style="padding-right: 25px;">
                    <div class="col-md-10 w90">
                        <p>Are you pregnant or nursing? <span style="text-align: end; float: right;">{{ $tattodata->are_you_pregnant_or_nursing == '1'?'yes':'No' }}</span></p>
                    </div>
                </div>
            </div>
            <!-- =-------------------------- -->

            <div class="row">
                <div class="col-md-12"></div>
            </div>
            <p style="">Any history of or current conditions of: <span style="font-size: 12px;"> (check all the apply)</span></p>
            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->cardiac_valve_disease == '1') checked @endif id="11" />
                        <label class="form-check-label" for="11">
                            Cardiac Valve Disease
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->high_blood_pressure == '1') checked @endif id="21" />
                        <label class="form-check-label" for="21">
                            High Blood Pressure
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->respiratory_disease == '1') checked @endif id="31" />
                        <label class="form-check-label" for="31">
                            Respiratory Disease
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->diabetes == '1') checked @endif id="12" />
                        <label class="form-check-label" for="12">
                            Diabetes
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->tumors_or_growths == '1') checked @endif id="22" />
                        <label class="form-check-label" for="22">
                            Tumors or Growths
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->hemophilia == '1') checked @endif id="32" />
                        <label class="form-check-label" for="32">
                            Hemophilia
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->liver_disease == '1') checked @endif id="13" />
                        <label class="form-check-label" for="13">
                            Liver Disease
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->bleeding_disorder == '1') checked @endif id="23" />
                        <label class="form-check-label" for="23">
                            Bleeding Disorder
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->kidney_disease == '1') checked @endif id="33" />
                        <label class="form-check-label" for="33">
                            Kidney Disease
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->epilepsy == '1') checked @endif id="14" />
                        <label class="form-check-label" for="14">
                            Epilepsy
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->jaundice == '1') checked @endif id="24" />
                        <label class="form-check-label" for="24">
                            Jaundice
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->exposure_to_aids == '1') checked @endif id="34" />
                        <label class="form-check-label" for="34">
                            Exposure to AIDS
                        </label>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->hepatitis == '1') checked @endif id="15" />
                        <label class="form-check-label" for="15">
                            Hepatitis
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value=""  @if($tattodata->venereal_disease == '1') checked @endif id="25" />
                        <label class="form-check-label" for="25">
                            Venereal Disease
                        </label>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="row mt-2">
                <div class="col-md-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" @if($tattodata->herpes_infection_at_proposed_procedure_site == '1') checked @endif id="65" />
                        <label class="form-check-label" for="65">
                            Herpes Infection at Proposed Procedure Site
                        </label>
                    </div>
                </div>
            </div>

            <!-- </div> -->
        </div>
        <div class="col-md-6" style="width: 50vw; padding: 20px;">
            <div class="container">
                <h2 class="uppercase">CLIENT INFORMATION</h2>
                <hr class="dotted" />
                <div class="row mt-10">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Name:</span>
                            <span class="opec">{{ $tattodata->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Today's Date</span>
                            <span class="opec">{{ date('d-m-Y',strtotime($tattodata->todaysdate)) }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Birth Date</span>
                            <span class="opec">{{ date('d-m-Y',strtotime($tattodata->birthdate)) }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Phone: (H/W/C)</span>
                            <span class="opec">{{ $tattodata->phone }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">Address</span>
                            <span class="opec">{{ $tattodata->address }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon3">State ID</span>
                            <span class="opec">{{ $tattodata->stateid }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="p-1">
                            Your signature declares your understanding and agreement of this Informed Consent, truthfulness in response of your medical history, and acknowledgment of being 18 years of age or older. Additionally, affirmation
                            that you have received your Post Procedure Instructions and have had opportunity to have any and all questions regarding the procedure answered.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label">Signature</label>
                            <br />
                            <input class="form-control form-control-sm" id="formFileSm" type="file" accept="image/*" onchange="readURL(this,'sign');" />
                            <img id="sign" src="{{ asset('storage/'.$tattodata->signature) }}" class="display-none imgx" alt="your image" />
                        </div>
                    </div>
                    <br />
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label">Driving Licence Front</label>
                            <input class="form-control form-control-sm" id="formFileSm" type="file" accept="image/*" onchange="readURL(this,'dl-front');" />
                            <img id="dl-front" src="{{ asset('storage/'.$tattodata->driving_licence_front) }}" class="display-none imgx" alt="your image" />
                        </div>
                    </div>
                    <br />
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label">Driving Licence Back</label>
                            <input class="form-control form-control-sm" id="formFileSm" type="file" accept="image/*" onchange="readURL(this,'dl-back');" />
                            <img id="dl-back" src="{{ asset('storage/'.$tattodata->driving_licence_back) }}" class="display-none imgx" alt="your image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <p class="text-center" style="width: 100vw; text-align: center;">This intellectual property belongs to the owner of THT and may not be copied without written consent from the author.</p>
        </div>
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

<style>
    .lin {
        background-color: #000000 !important;
        height: 2px !important;
        opacity: 0.6 !important;
        width: 50%;
    }

    hr.dotted {
        border: none;
        border-top: 1px dotted #000;
        color: #000000;
        /* Set the same color as your background */
        background-color: #fff;
        /* Set the same color as your background */
        height: 2px;
        opacity: 1;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .text-justify {
        text-align: justify;
    }

    .form-check-input {
        border-color: #000000 !important;
    }

    .imgx {
        max-width: 150px;
        max-height: 150px;
        border-radius: 20px;
    }

    .row {
        display: flex !important;
    }

    .text-justify {
        text-align: justify;
    }

    .w100 {
        width: 100%;
    }

    .col-md-4 {
        width: 33%;
    }

    .opec {
        color: gray;
        margin: 10px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center;
    }
</style>
