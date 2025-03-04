@extends('admin.master')
@section('content')

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0066cc;          /* Getlead primary blue */
            --primary-light: #e6f0ff;    /* Light blue for backgrounds */
            --primary-dark: #004b99;     /* Darker blue for hover states */
            --secondary: #00b373;        /* Green for success elements */
            --accent: #ff6b00;           /* Orange for accent/CTA */
            --light-bg: #f9fafc;         /* Light background */
            --card-bg: #ffffff;          /* Card background */
            --dark-text: #2d3748;        /* Dark text */
            --medium-text: #4a5568;      /* Medium text */
            --light-text: #718096;       /* Light text */
            --border: #e2e8f0;           /* Border color */
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            --radius: 8px;               /* Border radius */
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--dark-text);
            line-height: 1.6;
            background-color: var(--light-bg);
            font-size: 16px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        
        /*header {
            background: linear-gradient(120deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 3rem 0;
            margin-bottom: 2.5rem;
            box-shadow: var(--shadow);
        }*/
        
        header .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 1rem;
        }
        
        h2 {
            font-size: 1.8rem;
            color: var(--primary);
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--primary-light);
            margin-bottom: 1.5rem;
        }
        
        h3 {
            font-size: 1.4rem;
            color: var(--dark-text);
            margin: 1.5rem 0 1rem;
        }
        
        p {
            margin-bottom: 1rem;
            color: var(--medium-text);
        }
        
        .version {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            opacity: 0.9;
        }
        
        .section {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        ul, ol {
            margin-left: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        li {
            margin-bottom: 0.5rem;
            color: var(--medium-text);
        }
        
        .feature-box {
            background-color: var(--primary-light);
            border-left: 4px solid var(--primary);
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            border-radius: 0 var(--radius) var(--radius) 0;
        }
        
        .feature-title {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            font-family: 'Poppins', sans-serif;
        }
        
        .table-container {
            overflow-x: auto;
            margin-bottom: 1.5rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: var(--radius);
            overflow: hidden;
        }
        
        th, td {
            border: 1px solid var(--border);
            padding: 0.875rem 1rem;
            text-align: left;
        }
        
        th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        tr:nth-child(even) {
            background-color: var(--light-bg);
        }
        
        tr:hover {
            background-color: var(--primary-light);
        }
        
        .card {
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            font-weight: 600;
            font-size: 1.2rem;
            font-family: 'Poppins', sans-serif;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.75rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .partner-level {
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
        }
        
        .silver {
            border-top: 5px solid #C0C0C0;
        }
        
        .gold {
            border-top: 5px solid #FFD700;
        }
        
        .platinum {
            border-top: 5px solid #E5E4E2;
        }
        
        .highlight {
            background-color: var(--primary-light);
            padding: 1.25rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
        }
        
        .quick-facts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }
        
        .fact-item {
            background-color: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            border-top: 3px solid var(--primary);
            transition: transform 0.2s ease;
        }
        
        .fact-item:hover {
            transform: translateY(-5px);
        }
        
        .fact-title {
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--primary);
            font-family: 'Poppins', sans-serif;
        }
        
        .steps {
            counter-reset: step-counter;
            margin-left: 0;
            list-style-type: none;
        }
        
        .steps li {
            position: relative;
            padding-left: 3.5rem;
            margin-bottom: 1.5rem;
            min-height: 2.5rem;
            display: flex;
            align-items: center;
        }
        
        .steps li::before {
            content: counter(step-counter);
            counter-increment: step-counter;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 2px 5px rgba(0, 102, 204, 0.3);
        }
        
        footer {
            text-align: center;
            padding: 3rem 0;
            color: var(--light-text);
            /*background-color: var(--primary-dark);*/
            color: rgba(255, 255, 255, 0.9);
            margin-top: 3rem;
        }
        
        .contact-info {
            background-color: var(--primary-light);
            padding: 1.5rem;
            border-radius: var(--radius);
            margin-top: 1.5rem;
            border: 1px solid var(--border);
        }
        
        .contact-info h3 {
            color: var(--primary);
        }
        
        .btn-ap {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 2px 5px rgba(0, 102, 204, 0.3);
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 1rem;
        }
        
        .btn-ap:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 102, 204, 0.4);
        }
        
        .logo {
            height: 60px;
            margin-bottom: 1.5rem;
        }
        
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            
            .section {
                padding: 1.5rem;
            }
            
            .quick-facts {
                grid-template-columns: 1fr;
            }
            
            .steps li {
                padding-left: 3rem;
            }
        }
    </style>

    <div class="page-content">
        <div class="container-fluid">
            <!-- Start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <!--<h4 class="mb-0">TERMS & CONDITIONS</h4>-->
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                                <li class="breadcrumb-item active">About Program</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End page title -->


            <!-- Latest Leads -->
          <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

    <header>
        <div class="container">
            <!-- Logo would go here - placeholder for now -->
            <!-- <img src="logo.png" alt="Getlead CRM Logo" class="logo"> -->
            <h1>GETLEAD CRM PARTNER PROGRAM</h1>
            <p class="version">Document Version 2.0</p>
            <p>Last Updated: March 01, 2025</p>
            <!--<a href="#contact" class="btn">Become a Partner</a>-->
        </div>
    </header>
    
    <div class="container">
        <section class="section">
            <h2>EXECUTIVE SUMMARY</h2>
            <p>Getlead CRM offers an innovative partner program designed to create profitable, sustainable business opportunities for partners in Kerala and beyond. Our program enables you to grow your business while providing your clients with a cutting-edge CRM solution that drives measurable results.</p>
            
            <h3>Quick Facts</h3>
            <div class="quick-facts">
                <div class="fact-item">
                    <div class="fact-title">Product</div>
                    <p>Enterprise-grade CRM solution at SMB-friendly pricing</p>
                </div>
                <div class="fact-item">
                    <div class="fact-title">Base Pricing</div>
                    <p>₹899/user/month (monthly billing) or ₹599/user/month (annual billing)</p>
                </div>
                <div class="fact-item">
                    <div class="fact-title">Commission Structure</div>
                    <p>Tiered approach with up to 30% commission</p>
                </div>
                <div class="fact-item">
                    <div class="fact-title">Target Customers</div>
                    <p>SMBs across retail, manufacturing, professional services, and education sectors</p>
                </div>
                <div class="fact-item">
                    <div class="fact-title">Competitive Edge</div>
                    <p>Superior local support, flexible customization</p>
                </div>
            </div>
            
            <h3>Partner Benefits at a Glance</h3>
            <ul>
                <li>Recurring revenue stream and accelerating commissions</li>
                <li>Comprehensive sales and marketing enablement</li>
                <li>Dedicated partner manager and technical support</li>
                <li>Lead generation and co-marketing opportunities</li>
                <li>Certified training and skill development</li>
            </ul>
            
            <h3>Next Steps</h3>
            <ol class="steps">
                <li>Review this program document</li>
                <li>Complete the partner application</li>
                <li>Schedule onboarding with your dedicated partner manager</li>
                <li>Complete initial certification</li>
                <li>Launch your first campaign with our support</li>
            </ol>
        </section>
        
        <section class="section">
            <h2>INTRODUCTION</h2>
            <p>Getlead Analytics Private Limited, hereinafter referred to as "Company," is the creator and provider of Getlead CRM, a cutting-edge Software as a Service (SAAS) solution designed to empower small and medium-scale businesses by streamlining customer relationship management. At the core of our mission is the commitment to assist businesses in optimizing their customer interactions, fostering growth, and achieving sustained success.</p>
        </section>
        
        <section class="section">
            <h2>PRODUCT OVERVIEW</h2>
            <p>Getlead CRM is a comprehensive customer relationship management solution that offers a wide array of functionalities tailored to meet the diverse needs of businesses. It serves as a centralized hub for managing customer information, sales processes, and marketing efforts.</p>
            
            <h3>Key Features</h3>
            <div class="feature-box">
                <div class="feature-title">Lead Management</div>
                <p>Getlead CRM excels in lead management, providing tools for capturing, organizing, and nurturing leads throughout their lifecycle. It facilitates efficient lead tracking and conversion.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-title">Contact Management</div>
                <p>Our CRM offers robust contact management capabilities, enabling businesses to maintain up-to-date and organized customer databases.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-title">Sales Pipeline</div>
                <p>Getlead CRM visualizes the sales journey through an intuitive sales pipeline. This aids in monitoring opportunities, tracking progress, and closing deals effectively.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-title">Task and Calendar Management</div>
                <p>The CRM includes task and calendar management features, simplifying the scheduling of appointments, follow-ups, and other important activities.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-title">Reporting and Analytics</div>
                <p>Businesses can derive actionable insights from their data with our reporting and analytics tools. It provides valuable metrics for informed decision-making.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-title">Customization</div>
                <p>Getlead CRM is highly customizable, allowing businesses to tailor it to their specific needs, workflows, and industry requirements. This adaptability ensures a seamless fit for a variety of businesses.</p>
            </div>
            
            <div class="feature-box">
                <div class="feature-title">Integrations</div>
                <p>Connect your essential business tools with Getlead CRM through our powerful integration capabilities:</p>
                <ul>
                    <li>Social media integration with Facebook for lead capture and engagement</li>
                    <li>Email synchronization with popular providers for seamless communication tracking</li>
                    <li>Call integration for logging, recording, and analysis of customer conversations</li>
                    <li>WhatsApp Business API integration for direct customer messaging</li>
                    <li>Extensive API and webhook access for custom third-party integrations</li>
                </ul>
            </div>
            
            <h3>Benefits for Partners</h3>
            <p>Partnering with Getlead CRM offers a range of advantages, including:</p>
            
            <div class="card">
                <div class="card-header">Market-Proven Solution</div>
                <p>Gain access to a CRM solution that has demonstrated success in the market, with a track record of delivering results for businesses.</p>
            </div>
            
            <div class="card">
                <div class="card-header">Recurring Revenue</div>
                <p>Partners have the opportunity to generate recurring revenue through sales, support, and subscription-based models.</p>
            </div>
            
            <div class="card">
                <div class="card-header">Training and Certification</div>
                <p>We provide comprehensive training and certification programs to empower partners with the knowledge and skills needed to excel in promoting and implementing Getlead CRM.</p>
            </div>
            
            <div class="card">
                <div class="card-header">Marketing Support</div>
                <p>Partners can leverage our marketing support, including co-branding opportunities, marketing collateral, and lead generation assistance.</p>
            </div>
        </section>
        
        <section class="section">
            <h2>TIERED PARTNER PROGRAM STRUCTURE</h2>
            
            <div class="partner-level silver">
                <h3>Silver Partner</h3>
                <div class="highlight">
                    <p><strong>Requirements:</strong></p>
                    <ul>
                        <li>Complete basic certification</li>
                        <li>Minimum 3 sales per quarter</li>
                        <li>₹1.5 Lakh quarterly revenue commitment</li>
                    </ul>
                </div>
                <p><strong>Benefits:</strong></p>
                <ul>
                    <li>Basic commission structure</li>
                    <li>Partner portal access</li>
                    <li>Basic sales and marketing materials</li>
                    <li>Email and chat support</li>
                </ul>
            </div>
            
            <div class="partner-level gold">
                <h3>Gold Partner</h3>
                <div class="highlight">
                    <p><strong>Requirements:</strong></p>
                    <ul>
                        <li>Complete advanced certification</li>
                        <li>Minimum 6 sales per quarter</li>
                        <li>₹3 Lakh quarterly revenue commitment</li>
                        <li>Maintain 85% customer satisfaction</li>
                    </ul>
                </div>
                <p><strong>Benefits:</strong></p>
                <ul>
                    <li>Enhanced commission structure (+2%)</li>
                    <li>Co-marketing opportunities</li>
                    <li>Dedicated partner manager</li>
                    <li>Lead sharing program access</li>
                    <li>Priority technical support</li>
                </ul>
            </div>
            
            <div class="partner-level platinum">
                <h3>Platinum Partner</h3>
                <div class="highlight">
                    <p><strong>Requirements:</strong></p>
                    <ul>
                        <li>Complete expert certification</li>
                        <li>Minimum 10 sales per quarter</li>
                        <li>₹5 Lakh quarterly revenue commitment</li>
                        <li>Maintain 90% customer satisfaction</li>
                        <li>Industry specialization</li>
                    </ul>
                </div>
                <p><strong>Benefits:</strong></p>
                <ul>
                    <li>Premium commission structure (+5%)</li>
                    <li>Marketing development funds</li>
                    <li>Executive sponsor</li>
                    <li>Advanced lead sharing</li>
                    <li>Joint business planning</li>
                    <li>Early access to new features</li>
                </ul>
            </div>
        </section>
        
        <section class="section">
            <h2>TARGET AUDIENCE</h2>
            <p>Getlead CRM is ideally suited for small and medium-scale businesses across various industries. It caters to businesses looking to enhance their customer relationship management, sales, and marketing efforts for improved efficiency and growth.</p>
            
            <h3>Ideal Customer Profiles</h3>
            
            <div class="card">
                <div class="card-header">Small Business (5-25 employees)</div>
                <ul>
                    <li>Growing customer base becoming difficult to manage</li>
                    <li>Seeking to improve sales processes and customer retention</li>
                    <li>Budget-conscious but values quality support</li>
                    <li>Typical industries: Retail, professional services, hospitality</li>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header">Medium Business (26-100 employees)</div>
                <ul>
                    <li>Multiple departments needing coordination</li>
                    <li>Sales team of 5+ people requiring pipeline visibility</li>
                    <li>Looking to scale operations efficiently</li>
                    <li>Typical industries: Manufacturing, wholesale, education, technology</li>
                </ul>
            </div>
            
            <h3>Key Decision Makers</h3>
            <ul>
                <li>Business Owners</li>
                <li>Sales Directors/Managers</li>
                <li>Marketing Directors</li>
                <li>Operations Managers</li>
                <li>IT Managers (in larger organizations)</li>
            </ul>
            
            <h3>Regional Focus</h3>
            <ul>
                <li>Primary: Kochi, Trivandrum, Kozhikode</li>
                <li>Secondary: Thrissur, Kollam, Malappuram</li>
                <li>Tertiary: Other districts in Kerala</li>
            </ul>
        </section>
        
        <section class="section">
            <h2>PRICING AND SUBSCRIPTION PLANS</h2>
            
            <h3>Base Pricing</h3>
            <ul>
                <li>Monthly Billing: ₹899/user/month</li>
                <li>Quarterly Billing: ₹699/user/month</li>
                <li>Half-Yearly Billing: ₹799/user/month</li>
                <li>Annual Billing: ₹599/user/month</li>
            </ul>
            
            <h3>Implementation and Training</h3>
            <ul>
                <li>Implementation Charges: ₹7500 (one-time fee)</li>
                <li>Online Training: ₹2500 per hour</li>
                <li>Offline Training (in Kerala): ₹10000</li>
                <li>Customization Charges: ₹1500 per hour</li>
            </ul>
            
            <h3>Special Offers</h3>
            <ul>
                <li>Annual subscription customers receive complementary implementation support</li>
                <li>Volume discounts available for deployments with 10+ users</li>
                <li>Partner-referred customers eligible for priority onboarding</li>
            </ul>
            
            <h3>Billing Options</h3>
            <ul>
                <li>All plans can be billed monthly, quarterly, half-yearly, or annually</li>
                <li>Multi-year contracts available with additional benefits</li>
            </ul>
            
            <p class="highlight">Pricing effective March 1, 2025</p>
        </section>
        
        <section class="section">
            <h2>ENHANCED PARTNER PROGRAM OPTIONS</h2>
            
            <div class="card">
                <div class="card-header">1. Referral Partner</div>
                <p>As a Referral Partner, you will introduce businesses to Getlead CRM.</p>
                
                <p><strong>Responsibilities:</strong></p>
                <ul>
                    <li>Identify potential customers</li>
                    <li>Make initial introductions</li>
                    <li>Provide basic information about Getlead CRM</li>
                </ul>
                
                <p><strong>Support Provided:</strong></p>
                <ul>
                    <li>Referral tracking links</li>
                    <li>Basic marketing materials</li>
                    <li>Commission on successful sales</li>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header">2. Implementation Partner</div>
                <p>As an Implementation Partner, you'll assist businesses in setting up and optimizing their use of Getlead CRM.</p>
                
                <p><strong>Responsibilities:</strong></p>
                <ul>
                    <li>Assist with implementation and configuration</li>
                    <li>Provide training to customers</li>
                    <li>Offer ongoing support and optimization</li>
                </ul>
                
                <p><strong>Support Provided:</strong></p>
                <ul>
                    <li>Technical training and certification</li>
                    <li>Implementation guides and resources</li>
                    <li>Higher commission rates plus implementation fees</li>
                </ul>
            </div>
        </section>
        
        <section class="section">
            <h2>REVENUE SHARING AND COMMISSIONS</h2>
            
            <h3>Referral Partner Commission Structure</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Quarterly Sales Amount (INR)</th>
                            <th>Commission for Annual Plans</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Up to 1 Lakh</td>
                            <td>10%</td>
                        </tr>
                        <tr>
                            <td>1 Lakh - 3 Lakh</td>
                            <td>12%</td>
                        </tr>
                        <tr>
                            <td>3 Lakh - 5 Lakh</td>
                            <td>13%</td>
                        </tr>
                        <tr>
                            <td>Above 5 Lakh</td>
                            <td>15%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h3>Implementation Partner Commission Structure</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Quarterly Sales Amount (INR)</th>
                            <th>Commission for Annual Plans</th>
                            <th>Implementation Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Up to 1 Lakh</td>
                            <td>22%</td>
                            <td>100% (₹7,500)</td>
                        </tr>
                        <tr>
                            <td>3 Lakh - 5 Lakh</td>
                            <td>28%</td>
                            <td>100% (₹7,500)</td>
                        </tr>
                        <tr>
                            <td>Above 5 Lakh</td>
                            <td>30%</td>
                            <td>100% (₹7,500)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h3>Annual Plan Bonus Structure</h3>
            <p>(Additional fixed bonus on annual contracts)</p>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Annual Contract Value (INR)</th>
                            <th>Referral Partner Bonus</th>
                            <th>Implementation Partner Bonus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10,000 - 25,000</td>
                            <td>₹500</td>
                            <td>₹500</td>
                        </tr>
                        <tr>
                            <td>25,001 - 50,000</td>
                            <td>₹1,000</td>
                            <td>₹1,000</td>
                        </tr>
                        <tr>
                            <td>50,001 - 1,00,000</td>
                            <td>₹2,000</td>
                            <td>₹2,000</td>
                        </tr>
                        <tr>
                            <td>1,00,001 - 2,00,000</td>
                            <td>₹3,500</td>
                            <td>₹3,500</td>
                        </tr>
                        <tr>
                            <td>2,00,001 - 5,00,000</td>
                            <td>₹7,000</td>
                            <td>₹7,000</td>
                        </tr>
                        <tr>
                            <td>Above 5,00,000</td>
                            <td>₹10,000</td>
                            <td>₹10,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h3>Example Calculations</h3>
            
            <div class="card">
                <div class="card-header">Example 1: Annual Contract of ₹40,000</div>
                <p><strong>Referral Partner:</strong></p>
                <ul>
                    <li>Commission (10%): ₹4,000</li>
                    <li>Bonus: ₹1,000</li>
                    <li>Total: ₹5,000</li>
                </ul>
                <p><strong>Implementation Partner:</strong></p>
                <ul>
                    <li>Commission (22%): ₹8,800</li>
                    <li>Bonus: ₹1,000</li>
                    <li>Total: ₹9,800</li>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-header">Example 2: Annual Contract of ₹120,000</div>
                <p><strong>Referral Partner:</strong></p>
                <ul>
                    <li>Commission (12%): ₹14,400</li>
                    <li>Bonus: ₹3,500</li>
                    <li>Total: ₹17,900</li>
                </ul>
                <p><strong>Implementation Partner:</strong></p>
                <ul>
                    <li>Commission (25%): ₹30,000</li>
                    <li>Bonus: ₹3,500</li>
                    <li>Total: ₹33,500</li>
                </ul>
            </div>
            
            <p class="highlight">Pricing and commission structure effective March 1, 2025</p>
            
            <h3>Payment Timeline</h3>
            <ul>
                <li>Commissions paid 30 days after customer payment</li>
                <li>Minimum payout amount: ₹3,000</li>
                <li>Accelerated 15-day payment for Platinum partners</li>
            </ul>
            
            <h3>Commission Tracking</h3>
            <ul>
                <li>Real-time dashboard in partner portal</li>
                <li>Monthly commission statements</li>
                <li>Quarterly business reviews with performance analysis</li>
            </ul>
        </section>
        
        <section class="section">
            <h2>PARTNER ENABLEMENT</h2>
            
            <h3>Comprehensive Onboarding Program</h3>
            <ol>
                <li>Partner Application and Approval</li>
                <li>Welcome Email and Initial Training</li>
                <li>Product Certification</li>
                <li>Sales and Marketing Enablement</li>
                <li>Go-to-Market Planning</li>
                <li>First Customer Acquisition Support</li>
            </ol>
            
            <h3>Certification Levels</h3>
            <ul>
                <li>Level 1: Getlead Certified Associate - Basic product knowledge</li>
                <li>Level 2: Getlead Certified Professional - Advanced implementation skills</li>
                <li>Level 3: Getlead Certified Expert - Complete solution design capabilities</li>
                <li>Level 4: Getlead Certified Master - Strategic business consulting</li>
            </ul>
            
            <h3>Sales Enablement Tools</h3>
            <ul>
                <li>Customizable pitch decks</li>
                <li>Demo environment with sample data</li>
                <li>ROI calculator tool</li>
                <li>Email templates for prospecting</li>
                <li>Customer success stories</li>
            </ul>
            
            <h3>Technical Enablement</h3>
            <ul>
                <li>Implementation playbooks</li>
                <li>Configuration guides</li>
                <li>API documentation</li>
                <li>Integration manuals</li>
                <li>Troubleshooting resources</li>
                <li>Custom development guidelines</li>
            </ul>
        </section>
        
        <section class="section">
            <h2>PARTNER PORTAL</h2>
            <p>The Partner Portal serves as your central hub for all partner-related activities and resources.</p>
            
            <h3>Portal Features</h3>
            <ul>
                <li>Dashboard: View performance metrics, commission status, and announcements</li>
                <li>Lead Management: Register and track opportunities</li>
                <li>Commission Tracking: Real-time view of earned and pending commissions</li>
            </ul>
        </section>
        
        <section class="section">
            <h2>PARTNER COMMUNICATIONS</h2>
            
            <h3>Regular Communication Cadence</h3>
            <ul>
                <li>Weekly: Email bulletin with product updates and tips</li>
                <li>Monthly: Partner webinar showcasing features and success stories</li>
                <li>Quarterly: Business review with dedicated partner manager</li>
                <li>Annual: Partner summit and recognition event</li>
            </ul>
            
            <h3>Communication Channels</h3>
            <ul>
                <li>Partner portal announcements</li>
                <li>Email newsletters</li>
                <li>Webinars and virtual events</li>
                <li>Private partner community</li>
                <li>Dedicated Slack/Teams channel for Platinum partners</li>
            </ul>
            
            <h3>Feedback Mechanisms</h3>
            <ul>
                <li>Regular surveys and feedback sessions</li>
                <li>Product enhancement request system</li>
            </ul>
        </section>
        
        <section class="section" id="contact">
            <h2>SUPPORT & COMMUNICATION</h2>
            
            <h3>Technical Support</h3>
            <ul>
                <li>Support email: support@getleadcrm.com</li>
                <li>Support hours: 9 AM to 6 PM, Monday to Saturday</li>
                <li>Emergency support: Available 24/7 for critical issues +918453555000</li>
            </ul>
            
            <h3>Feature Updates & Training</h3>
            <ul>
                <li>Regular release notes and update notifications</li>
                <li>Scheduled training sessions for new features</li>
                <li>On-demand training videos in the partner portal</li>
                <li>Quarterly product roadmap webinars</li>
            </ul>
            
            <h3>Dedicated Partner Manager</h3>
            <p>An exclusive manager will be at your disposal to assist with:</p>
            <ul>
                <li>Strategic planning and goal setting</li>
                <li>Opportunity development and sales strategy</li>
                <li>Issue resolution and escalation</li>
                <li>Performance optimization recommendations</li>
            </ul>
            
            <div class="contact-info">
                <h3>Office Location</h3>
                <p>
                    Unit-2 Upper Basement<br>
                    Sahya Building Cyber Park<br>
                    Calicut-16<br>
                    Kerala, India
                </p>
            </div>
        </section>
        
        <footer>
            <div class="container">
                <p>Thank you for your interest in becoming a Getlead CRM partner. We look forward to growing together and helping businesses in Kerala reach new heights of success!</p>
                <p style="margin-top: 20px;">Warm Regards,<br>Team Getlead CRM</p>
                <!--<a href="#contact" class="btn" style="margin-top: 20px;">Become a Partner Today</a>-->
            </div>
        </footer>
    </div>




                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@push('scripts')

<script type="text/javascript">
   
   var table = $('#business-leads-table').DataTable({
            processing: true,
            serverSide: true,
			stateStatus: true,
			"language": {
				searchPlaceholder: 'Search',
				sSearch: '',
			},
			"lengthMenu": [10, 25, 50,100,150,200],
			
            ajax: {
                url: "{{ route('partner.get-business-leads') }}",
                data: function (d) 
                {
                }
            },
		
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
				{data: 'name', name: 'name'},
				{data: 'email', name: 'email'},
				{data: 'mobile', name: 'mobile'},
				{data: 'company_name', name: 'company_name'},
				{data: 'address', name: 'address'},
				{data: 'area', name: 'area'},
				{data: 'lead_status', name: 'lead_status'},
            ],
   });
   
</script>
@endpush

@endsection
