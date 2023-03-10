# Building_IT_system (COSC2634)

### A. Contributors:
- Luu Quoc Nhat (S3924942) - Coder in chief
- Nguyen Nhat Minh (S3932112) - Product Owner
- Luong Thao My (S3922086) - Scrum master
- Tran Gia Minh Thong (S3924667) - Writer in Chief

### B. Introduction:
  Blood Mana is an web application particularly used in blood donation industry. The growing needs of blood donation in emergency cases had motivated us to build an application for the community. Our effort is to enhance the communication between donors and hospitals, and the collaboration between hospitals within our ecosystem. Also, our application helps to streamline the blood donation and delivery procedure. 

  To achieve those goals, we has built 3 seperate user modules: hospitals, donors, and system admin. Specifically:
  Hospital employee module: hospitals need to contact with the system admins to be members within the Blood Mana ecosystem. They may need to sign up as donation centers in order to launch donation campaigns, which are generated to receive blood donation from the community. Our application will provide a HR account for the hospital so that they can sign up for delivery and database officers depending on their needs. Depending on the working positions, hospital employee will execute their tasks on different workspaces. 

  Donor module: a citizen can register to be a donor. 

  System admin module: a system admin can perform their tasks on the admin dashboard. They are able to manage most entities within the system.  

### C. Technical Outcomes:
- Security ensurrance: I had implemented counter measures fight against security attacks (e.g., brute-force, SQLi, XSS). The application provides privilleges to authorized access. For instance, a database officer cannot access admin dashboard and donor's pages.
- Online workspaces:

- Donation scheduling: After specifying basic information such as national ID and address, donors can book donation appointment before coming to the donation centers. The Blood Mana will render the top three nearest donation centers based on donor's location.
- Launching donation campaigns: 
- Shipping route: In the delivery officer's workspace, a shipping route to the destination will be rendered if that staff is assigned for the delivery tasks.  

### F. Limitations:
- The free trial GGAPI KEY may not work and the application may exceed the limit daily quotes. This will negatively affect donation scheduling and shipping route features.
- The shipping route may not work in cases the distance betweeen the source and the destination is two large.
