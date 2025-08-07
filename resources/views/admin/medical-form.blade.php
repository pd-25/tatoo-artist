<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tattoo Informed Consent & Medical History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        :root {
            --primary-color: #1a1a2e;
            --secondary-color: #16213e;
            --accent-color: #0f3460;
            --highlight-color: #e94560;
            --light-color: #f8f9fa;
            --border-color: #dee2e6;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .tattoo-container {
            max-width: 1200px;
            margin: 2rem auto;
            background: white;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .tattoo-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2.5rem 1rem;
            text-align: center;
            position: relative;
        }

        .tattoo-header::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--highlight-color);
        }

        .tattoo-header h1 {
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }

        .tattoo-header h3 {
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .section-title {
            color: var(--accent-color);
            border-bottom: 2px solid var(--highlight-color);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .section-title::after {
            content: "";
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--accent-color);
        }

        .consent-content {
            padding: 2rem;
        }

        .consent-text {
            margin-bottom: 1.5rem;
            text-align: justify;
        }

        .medical-history {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--accent-color);
        }

        .question-row {
            border-bottom: 1px dashed var(--border-color);
            padding: 0.75rem 0;
        }

        .question-row:last-child {
            border-bottom: none;
        }

        .condition-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .condition-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            background: white;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .condition-item input {
            margin-right: 0.75rem;
        }

        .client-info-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.05);
            border-top: 4px solid var(--highlight-color);
        }

        .info-group {
            margin-bottom: 1.25rem;
        }

        .info-label {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 0.25rem;
        }

        .info-value {
            padding: 0.5rem 0;
            font-size: 1.05rem;
            border-bottom: 1px solid var(--border-color);
        }

        .signature-area {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .signature-images {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .signature-img-container {
            flex: 1;
            min-width: 200px;
            text-align: center;
        }

        .signature-img-container img {
            max-width: 100%;
            max-height: 150px;
            border: 1px solid var(--border-color);
            border-radius: 0.25rem;
            background: white;
            padding: 0.5rem;
        }

        .signature-label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }

        .disclaimer {
            padding: 1.5rem;
            text-align: center;
            background: #f8f9fa;
            border-top: 1px solid var(--border-color);
            font-size: 0.9rem;
            color: #6c757d;
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            background: var(--highlight-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
        }

        .print-btn i {
            margin-right: 8px;
        }

        @media print {
            .print-btn {
                display: none;
            }

            .tattoo-container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }

            body {
                background: white;
                padding: 0;
            }
        }

        @media (max-width: 768px) {
            .condition-grid {
                grid-template-columns: 1fr;
            }

            .signature-images {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="tattoo-container">
        <div class="tattoo-header">
            <h1>Tattoo Informed Consent & Medical History</h1>
            <h3>{{ $artistdata->name }} </h3>
            <h5>
                {{ $artistdata->artistData->shop_address ?? '' }}
                @if($artistdata->address2) {{ $artistdata->address2 }} @endif
                @if($artistdata->city) , {{ $artistdata->city }} @endif
                @if($artistdata->state) , {{ $artistdata->state }} @endif
                @if($artistdata->country) , {{ $artistdata->country }} @endif
                @if($artistdata->zipcode) - {{ $artistdata->zipcode }} @endif
            </h5>
        </div>

        <div class="consent-content">
            <div class="consent-text">
                <p>
                    I am signing this agreement to induce {{ $artistdata->name }} and the Subcontracted Tattoo Artist (STA) to modify my tattoo and/or tattoo my person. In consideration of doing so, I hereby release {{ $artistdata->name }} and its employees
                    and agents from all manner of liabilities, claims, actions and demands in law or in equity which I or my heirs have or might have now or hereafter by reason of complying with my request to be tattooed.
                </p>
                <p>
                    I am promising to disclose on this medical form and to my STA if I have any of the following conditions, including but not limited to, a history of Herpes Infection at the proposed procedure site, Diabetes, Allergic reactions
                    to latex or antibiotics, Hemophilia or other bleeding disorders, or Cardiac Vascular Disease, Epilepsy, Keloiding (excessive scarring), AIDS or HIV, AIDS Related Complex (ARC), under the influence of drugs or alcohol, and
                    Swelling, Lumps, or signs of irritation of the area to be tattooed or any related health risks. I will disclose if I am currently using medication, including being prescribed antibiotics prior to dental or surgical
                    procedures. Additionally, I will share if other risk factors for bloodborne pathogen exposure exist in my daily life. To my knowledge I do not have any physical, mental, or medical impairments or disability which might
                    affect my well being as a direct or indirect result from my decision to have tattoo work done at this time. Some of these conditions include pregnancy and but not limed to a history of severe asthma attacks
                </p>
                <p>
                    The procedure of getting a tattoo means the insertion of pigment in human skin tissue by piercing it with a needle. It is permanent. I am aware that tattooing is a hazardous activity, and am voluntarily participating with
                    knowledge of the risks involved, which include infection or other injury. I understand it can be expensive and painful to remove a tattoo and that the process is not always successful and may result in scarring. Additional
                    information regarding this procedure are {{ $artistdata->name }} 's Post Procedure Instructions. With full knowledge of the dangers and risks involved I hereby agree and accept all risks of any kind or nature. Being of sound mind
                    and body, I hereby release any and all persons representing {{ $artistdata->name }} from all responsibility and liability for any consequences
                </p>
                <p>
                    that may stem from my decision to have tattoo work done. I hereby agree to hold harmless all owners, agents, employees, and representatives of {{ $artistdata->name }} . I further agree not to file any suit, claim, or action for any damages,
                    demands, rights, or causes of action for any nature, including but not limited to injury, maiming, property damage or death to myself or any other person arising from my decision to have tattoo work done by {{ $artistdata->name }} , its owners,
                    agents, employees or representatives harmless of all damages, actions, causes of action, claim judgements, cost of litigation, attorney fees, and any and all costs and expenses which may arise from my decision to have tattoo
                    work done by {{ $artistdata->name }}
                </p>
                <p>
                    I agree to leave the premises of {{ $artistdata->name }} promptly upon request by any owner, agent, employee, or representative of {{ $artistdata->name }} for any reason whatsoever. I agree these waivers and releases pertain to and are directed to protect {{ $artistdata->name }} .
                </p>
            </div>

            <div class="row">
                <div class="col-md-12 text-center mb-4">
                    <div class="alert alert-warning">
                        <strong>The FDA has not approved the use of any tattoo ink.</strong>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="medical-history">
                        <h3 class="section-title">MEDICAL HISTORY</h3>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Are you in general good health at this time?</span>
                                <strong>{{ $tattodata->general_good_health == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Are you under any medical treatment now?</span>
                                <strong>{{ $tattodata->you_under_any_medical_treatment == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Are you currently taking any drugs or medications?</span>
                                <strong>{{ $tattodata->you_currently_taking_any_drugs == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Do you have a history of medication use?</span>
                                <strong>{{ $tattodata->you_have_a_history_of_medication == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Do you have a history of fainting?</span>
                                <strong>{{ $tattodata->you_have_a_history_of_fainting == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Are you allergic to latex?</span>
                                <strong>{{ $tattodata->are_you_allergic_to_latex == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Have any wounds healed slowly or presented other complications?</span>
                                <strong>{{ $tattodata->have_any_wounds_healed_slowly == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Are you allergic to any know materials or medications (or antibiotics) resulting in hives, asthma, eczema, etc.?</span>
                                <strong>{{ $tattodata->are_you_allergic_to_any_know_materials == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Any risk factors from work or lifestyle, that lead to exposure for bloodborne pathogens?</span>
                                <strong>{{ $tattodata->any_risk_factors_from_work_or_lifestyle == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <div class="question-row">
                            <div class="d-flex justify-content-between">
                                <span>Are you pregnant or nursing?</span>
                                <strong>{{ $tattodata->are_you_pregnant_or_nursing == '1'?'yes':'No' }}</strong>
                            </div>
                        </div>

                        <p class="mt-4">Any history of or current conditions of: <small class="text-muted">(check all that apply)</small></p>

                        <div class="condition-grid">
                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->cardiac_valve_disease == '1') checked @endif id="11" />
                                <label class="form-check-label" for="11">
                                    Cardiac Valve Disease
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->high_blood_pressure == '1') checked @endif id="21" />
                                <label class="form-check-label" for="21">
                                    High Blood Pressure
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->respiratory_disease == '1') checked @endif id="31" />
                                <label class="form-check-label" for="31">
                                    Respiratory Disease
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->diabetes == '1') checked @endif id="12" />
                                <label class="form-check-label" for="12">
                                    Diabetes
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->tumors_or_growths == '1') checked @endif id="22" />
                                <label class="form-check-label" for="22">
                                    Tumors or Growths
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->hemophilia == '1') checked @endif id="32" />
                                <label class="form-check-label" for="32">
                                    Hemophilia
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->liver_disease == '1') checked @endif id="13" />
                                <label class="form-check-label" for="13">
                                    Liver Disease
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->bleeding_disorder == '1') checked @endif id="23" />
                                <label class="form-check-label" for="23">
                                    Bleeding Disorder
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->kidney_disease == '1') checked @endif id="33" />
                                <label class="form-check-label" for="33">
                                    Kidney Disease
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->epilepsy == '1') checked @endif id="14" />
                                <label class="form-check-label" for="14">
                                    Epilepsy
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->jaundice == '1') checked @endif id="24" />
                                <label class="form-check-label" for="24">
                                    Jaundice
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->exposure_to_aids == '1') checked @endif id="34" />
                                <label class="form-check-label" for="34">
                                    Exposure to AIDS
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->hepatitis == '1') checked @endif id="15" />
                                <label class="form-check-label" for="15">
                                    Hepatitis
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->venereal_disease == '1') checked @endif id="25" />
                                <label class="form-check-label" for="25">
                                    Venereal Disease
                                </label>
                            </div>

                            <div class="condition-item">
                                <input class="form-check-input" type="checkbox" value="" @if($tattodata->herpes_infection_at_proposed_procedure_site == '1') checked @endif id="65" />
                                <label class="form-check-label" for="65">
                                    Herpes Infection at Proposed Procedure Site
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="client-info-card">
                        <h3 class="section-title">CLIENT INFORMATION</h3>

                        <div class="info-group">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $tattodata->name }}</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Today's Date</div>
                                    <div class="info-value">{{ date('m-d-Y',strtotime($tattodata->todaysdate)) }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-group">
                                    <div class="info-label">Birth Date</div>
                                    <div class="info-value">{{ date('m-d-Y',strtotime($tattodata->birthdate)) }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Phone: (H/W/C)</div>
                            <div class="info-value">{{ $tattodata->phone }}</div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">Address</div>
                            <div class="info-value">{{ $tattodata->address }}</div>
                        </div>

                        <div class="info-group">
                            <div class="info-label">State ID</div>
                            <div class="info-value">{{ $tattodata->stateid }}</div>
                        </div>

                        <div class="signature-area">
                            <p>
                                Your signature declares your understanding and agreement of this Informed Consent, truthfulness in response of your medical history, and acknowledgment of being 18 years of age or older. Additionally, affirmation
                                that you have received your Post Procedure Instructions and have had opportunity to have any and all questions regarding the procedure answered.
                            </p>

                            <div class="signature-images">
                                <div class="signature-img-container">
                                    <img src="{{ asset('storage/'.$tattodata->signature) }}" alt="Client Signature">
                                    <div class="signature-label">Signature</div>
                                </div>

                                <div class="signature-img-container">
                                    <img src="{{ asset('storage/'.$tattodata->driving_licence_front) }}" alt="Driver License Front">
                                    <div class="signature-label">Driving Licence Front</div>
                                </div>

                                <div class="signature-img-container">
                                    <img src="{{ asset('storage/'.$tattodata->driving_licence_back) }}" alt="Driver License Back">
                                    <div class="signature-label">Driving Licence Back</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="disclaimer">
            <p>This intellectual property belongs to the owner of {{ $artistdata->name }} and may not be copied without written consent from the author.</p>
        </div>
    </div>

    <button id="printBtn" class="print-btn">
        <i class="fas fa-print"></i> Print Document
    </button>

    <script>
        $(document).ready(function() {
            // Print button functionality
            $('#printBtn').click(function() {
                window.print();
            });

            // Simple animation for checked conditions
            $('.condition-item input').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.condition-item').css('background-color', '#e8f4ff');
                } else {
                    $(this).closest('.condition-item').css('background-color', 'white');
                }
            });
        });
    </script>
</body>

</html>