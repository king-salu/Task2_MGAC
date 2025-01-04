# Overview

---

- [First Section](#section-1)

<a name="section-1"></a>
## API TEST FOR LEGACY PLATFORMS

### Task Overview
You will create a "Mini Global API Centre" (MGAC) with APIs that connect three key services
 within an imaginary platform: Stanbic Authentication System (SAS), Stanbic Smart Wallet
 (SWM), and Stanbic Mint Centre (SMC). You are required to design and implement endpoints
 that handle essential interactions among these services, emphasizing security and
 performance.
 For the platform called Stanbic, do note that each of the above sub-systems mentioned above
 are independent but are interconnected thanks to the API–based interfacing where certain
 activities, components, or systems functions across multiple sub-platforms.
 For example, the Stanbic Authentication System is the central single-sign-on technology and
 also serves the purpose of account verification, validation, and authorization. So when Anna
 wants to mint on the separate SMC sub-platform, her account can be authenticated directly
 without her having to necessarily create a new account since SAS already have the account
 shared across all of these platforms.
 The same applies if Anna tries to fund her SMC account, the account balance is an interface
 powered by the SWM for financial safekeeping and accountable logs.
 The whole point is the interconnectedness and reliance each platform has on one another. This
 is why the API are important. Remember, this is an imaginary application whose API you must
 create, implement, deploy, and test alone