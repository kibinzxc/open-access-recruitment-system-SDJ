import pytest, allure

def login(page, email, password):
    page.get_by_role("textbox", name="Email").fill(email)
    page.get_by_role("textbox", name="Password").fill(password)
    page.get_by_role("button", name="Sign In").click()
    try:
        page.wait_for_function("document.title === 'Dashboard | Admin'", timeout=5000)
        return True
    except:
        return False

@pytest.mark.parametrize("email, password, expected_result", [
    ("sweetdreamjob@gmail.com", "Password123!", True),
    ("invalid@example.com", "wrongpassword", False),
    ("test@gmail.com", "hahages545t124", True)
])

@allure.severity(allure.severity_level.BLOCKER)
def test_login(page, email, password, expected_result):
    page.goto("https://admin.sweetdreamjob.com/")
    result = login(page, email, password)
    assert result == expected_result
