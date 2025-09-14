import pytest
import allure
import subprocess  # for running allure command after tests


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
    """Automatically open Allure report after tests (only if there are failures)."""
    if exitstatus != 0:  # if tests failed
        # This opens the report in your default browser
        subprocess.Popen(["allure.bat", "serve", "allure-results"])

