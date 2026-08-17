<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Quiz App - Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-blue-dark: #1d4ed8;
            --light-blue-bg: #f0f7ff;
            --border-blue: #bfdbfe;
        }
        body {
            background-color: var(--light-blue-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            padding: 1.5rem;
        }
        .card-custom {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.08);
            border: 1px solid var(--border-blue);
            width: 100%;
            max-width: 520px;
            padding: 2.5rem;
        }
        .accent-header {
            border-left: 4px solid var(--primary-blue);
            padding-left: 1rem;
            margin-bottom: 2rem;
        }
        .accent-header .title {
            color: #1e293b;
        }
        .accent-header .subtitle {
            color: #64748b;
        }
        .label {
            color: #334155;
            font-weight: 600;
        }
        .input {
            border-radius: 8px;
            border-color: #cbd5e1;
            box-shadow: none;
        }
        .input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .button.is-link {
            background-color: var(--primary-blue);
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }
        .button.is-link:hover:not([disabled]) {
            background-color: var(--primary-blue-dark);
        }
        .step-badge {
            display: inline-block;
            background-color: #dbeafe;
            color: var(--primary-blue-dark);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

<main class="card-custom">
    <span class="step-badge">Step 1 of 3</span>
    <div class="accent-header">
        <h1 class="title is-3 mb-1">User Registration</h1>
        <h2 class="subtitle is-6">
            Enter your details below to begin the quiz.
        </h2>
    </div>

    <!-- Form handler target: instructions.php, Method: POST -->
    <form method="POST" action="instructions.php" id="registration-form">
        <div class="field mb-4">
            <label class="label">Complete Name <span class="has-text-danger">*</span></label>
            <div class="control">
                <input class="input" type="text" id="complete_name" name="complete_name" placeholder="e.g. Juan Dela Cruz" required>
            </div>
        </div>

        <div class="field mb-4">
            <label class="label">Email Address <span class="has-text-danger">*</span></label>
            <div class="control">
                <input class="input" type="email" id="email" name="email" placeholder="e.g. juan@example.com" required />
            </div>
        </div>

        <div class="field mb-4">
            <label class="label">Birthdate</label>
            <div class="control">
                <input class="input" id="birthdate" name="birthdate" type="date" />
            </div>
        </div>

        <div class="field mb-5">
            <label class="label">Contact Number</label>
            <div class="control">
                <input class="input" id="contact_number" name="contact_number" type="number" placeholder="e.g. 09123456789" />
            </div>
        </div>

        <div class="field">
            <button type="submit" id="next-btn" class="button is-link is-fullwidth" disabled>Proceed Next</button>
        </div>
    </form>
</main>

<script>
    const nameInput = document.getElementById('complete_name');
    const emailInput = document.getElementById('email');
    const nextBtn = document.getElementById('next-btn');

    function validateRegistration() {
        const nameVal = nameInput.value.trim();
        const emailVal = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const isNameValid = nameVal !== '';
        const isEmailValid = emailRegex.test(emailVal);

        if (isNameValid && isEmailValid) {
            nextBtn.removeAttribute('disabled');
        } else {
            nextBtn.setAttribute('disabled', 'disabled');
        }
    }

    nameInput.addEventListener('input', validateRegistration);
    emailInput.addEventListener('input', validateRegistration);
</script>
</body>
</html>
