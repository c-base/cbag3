# Use `useForm` react hook for handling forms
React forms need validation and and event-handling for user feedback and when the form is submitted.
Since there will be more form fields / forms in the future that need handling, we need a simple way that can be applied to all.

## Decision
I chose `React Hook Form` https://react-hook-form.com/ 

## Rationale
`React Hook Form` has the least things that need to happen in order to work with the way the actual code is implemented right now.

## Status
Accepted

## Consequences
After using it in one place for uploading images all forms can use simple frontend validation.
Downside right now is that validation constraints need to be repeated in the frontend.