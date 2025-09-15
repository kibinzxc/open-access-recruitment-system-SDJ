import pytest
import allure
import subprocess, sys, os  # for running allure command after tests


@pytest.hookimpl(tryfirst=True, hookwrapper=True)
def pytest_runtest_makereport(item, call):
    # This gives us the test result after each phase (setup, call, teardown)
    outcome = yield
    result = outcome.get_result()

    if result.when == "call" and result.failed:
        # Try to get Playwright page object from test
        page = item.funcargs.get("page", None)
        if page:
            # Attach screenshot
            screenshot = page.screenshot()
            allure.attach(
                screenshot,
                name="screenshot",
                attachment_type=allure.attachment_type.PNG
            )

# 🔹 Automatically open Allure report after pytest session

def pytest_sessionfinish(session, exitstatus):
    # Only run allure serve locally on Windows
    if os.name == "nt":  # Windows
        try:
            subprocess.Popen(["allure.bat", "serve", "allure-results"])
        except FileNotFoundError:
            print("Allure not found locally.")
    else:
        print("Skipping Allure serve on non-Windows environments.")
