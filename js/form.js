const form       = document.querySelector("form")
const formAction = form.action
const formInputs = document.querySelectorAll("form input")
const formSubmit = document.querySelector("input[type='submit']")

function validForm()
{
	let valid = true

	formInputs.forEach(input => {
		if (input.value === "")
		{
			valid = false
		}
	})

	return valid
}

document.onclick = (event) => {
	if (event.target === formSubmit)
	{
		if (validForm())
		{
			form.action = formAction
		}
		else
		{
			form.action = "javascript:void(0)"
		}
	}
}
