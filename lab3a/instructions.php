<?php
# from the $_SERVER global variable, check if the HTTP method used is POST, if its not POST, redirect to the index.php page
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$complete_name = $_POST['complete_name'] ?? '';
$email = $_POST['email'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';

$name_parts = explode(' ', trim($complete_name));
$first_name = !empty($name_parts[0]) ? $name_parts[0] : 'User';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Quiz App - Instructions</title>
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
            max-width: 580px;
            padding: 2.5rem;
        }
        .accent-header {
            border-left: 4px solid var(--primary-blue);
            padding-left: 1rem;
            margin-bottom: 1.75rem;
        }
        .accent-header .title {
            color: #1e293b;
        }
        .accent-header .subtitle {
            color: #64748b;
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
        .label {
            color: #334155;
            font-weight: 600;
        }
        .textarea[readonly] {
            background-color: #f8fafc;
            color: #475569;
            cursor: not-allowed;
            border-color: #cbd5e1;
            resize: vertical;
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
    </style>
</head>
<body>

<main class="card-custom">
    <span class="step-badge">Step 2 of 3</span>
    <div class="accent-header">
        <h1 class="title is-3 mb-1">Hello <?php echo htmlspecialchars($first_name); ?>, please read the instructions first</h1>
        <h2 class="subtitle is-6">
            This is the IPT10 PHP Quiz Web Application Laboratory Activity.
        </h2>
    </div>

    <!-- Target form handler resource: quiz.php with POST method -->
    <form method="POST" action="quiz.php" id="instructions-form">
        <input type="hidden" name="complete_name" value="<?php echo htmlspecialchars($complete_name); ?>" />
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />
        <input type="hidden" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" />
        <input type="hidden" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>" />

        <div class="content mb-4">
            <p>
                Welcome to the quiz! Please read all instructions carefully before starting:
            </p>
            <ul>
                <li>You will have <strong>60 seconds</strong> to complete all quiz questions.</li>
                <li>All questions will be displayed at once on the next screen.</li>
                <li>When the timer expires, your answers will automatically be submitted.</li>
            </ul>
        </div>

        <div class="field mb-4">
            <label class="label">Terms and conditions</label>
            <div class="control">
                <textarea class="textarea" readonly rows="5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</textarea>
            </div>
        </div>

        <div class="field mb-5">
            <div class="control">
                <label class="checkbox">
                    <input type="checkbox" id="agree-check" name="agree" value="1">
                    I agree to the terms and conditions
                </label>
            </div>
        </div>

        <!-- Start Quiz button -->
        <div class="field">
            <button type="submit" id="start-btn" class="button is-link is-fullwidth" disabled>Start Quiz</button>
        </div>
    </form>
</main>

<script>
    const agreeCheck = document.getElementById('agree-check');
    const startBtn = document.getElementById('start-btn');

    agreeCheck.addEventListener('change', function() {
        if (this.checked) {
            startBtn.removeAttribute('disabled');
        } else {
            startBtn.setAttribute('disabled', 'disabled');
        }
    });
</script>

</body>
</html>