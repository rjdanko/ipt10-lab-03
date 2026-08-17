<?php
require "helpers.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$complete_name = $_POST['complete_name'] ?? '';
$email = $_POST['email'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$agree = $_POST['agree'] ?? '';

$questions_data = retrieve_questions();
$questions = $questions_data['questions'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Quiz App - Questions</title>
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
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            padding: 2rem 1rem;
        }
        .quiz-container {
            max-width: 760px;
            margin: 0 auto;
        }
        .timer-header {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.08);
            border: 1px solid var(--border-blue);
            padding: 1.25rem 1.75rem;
            position: sticky;
            top: 1rem;
            z-index: 100;
            margin-bottom: 2rem;
        }
        .question-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.05);
            border: 1px solid #e2e8f0;
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            transition: border-color 0.2s ease;
        }
        .question-card:hover {
            border-color: var(--border-blue);
        }
        .question-num {
            display: inline-block;
            background-color: #dbeafe;
            color: var(--primary-blue-dark);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            margin-bottom: 0.5rem;
        }
        .question-title {
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .radio-option {
            display: block;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .radio-option:hover {
            background: #eff6ff;
            border-color: var(--border-blue);
        }
        .radio-option input[type="radio"] {
            margin-right: 0.5rem;
        }
        .button.is-link {
            background-color: var(--primary-blue);
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }
        .button.is-link:hover {
            background-color: var(--primary-blue-dark);
        }
    </style>
</head>
<body>

<div class="quiz-container">
    <!-- Sticky Timer Header -->
    <div class="timer-header is-flex is-justify-content-space-between is-align-items-center" id="timer-box">
        <div>
            <span class="tag is-info is-light">Step 3 of 3</span>
            <h1 class="title is-5 mb-0 mt-1">IPT10 Trivia Quiz</h1>
        </div>
        <div class="has-text-right">
            <span class="is-size-7 has-text-grey">Time Remaining</span>
            <div class="title is-4 mb-0 has-text-link" id="countdown">60s</div>
        </div>
    </div>

    <!-- Form submits ALL questions at once to result.php -->
    <form method="POST" action="result.php" id="quiz-form">
        <input type="hidden" name="complete_name" value="<?php echo htmlspecialchars($complete_name); ?>" />
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />
        <input type="hidden" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" />
        <input type="hidden" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>" />
        <input type="hidden" name="agree" value="<?php echo htmlspecialchars($agree); ?>" />

        <?php foreach ($questions as $index => $q): ?>
            <div class="question-card">
                <span class="question-num">Question <?php echo ($index + 1); ?> of <?php echo count($questions); ?></span>
                <h2 class="question-title is-size-5"><?php echo htmlspecialchars($q['question']); ?></h2>

                <div class="field">
                    <?php foreach ($q['options'] as $option): ?>
                        <label class="radio-option">
                            <input type="radio" name="answers[<?php echo $index; ?>]" value="<?php echo $option['key']; ?>">
                            <strong><?php echo $option['key']; ?>.</strong> <?php echo htmlspecialchars($option['value']); ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="field mt-5 mb-6">
            <button type="submit" class="button is-link is-large is-fullwidth">Submit Answers</button>
        </div>
    </form>
</div>

<script>
    let timeLeft = 60;
    const countdownEl = document.getElementById('countdown');
    const timerBox = document.getElementById('timer-box');
    const quizForm = document.getElementById('quiz-form');

    const timerInterval = setInterval(() => {
        timeLeft--;
        countdownEl.textContent = timeLeft + 's';

        if (timeLeft <= 10) {
            countdownEl.className = "title is-4 mb-0 has-text-danger";
            timerBox.style.borderColor = "#fca5a5";
            timerBox.style.backgroundColor = "#fef2f2";
        }

        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            quizForm.submit();
        }
    }, 1000);
</script>
</body>
</html>