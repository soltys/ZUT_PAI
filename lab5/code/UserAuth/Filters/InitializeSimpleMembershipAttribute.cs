using System;
using System.Data.Entity;
using System.Data.Entity.Infrastructure;
using System.Threading;
using System.Web.Mvc;
using System.Web.Security;
using WebMatrix.WebData;
using UserAuth.Models;
[assembly: WebActivator.PostApplicationStartMethod(typeof(UserAuth.Filters.SimpleMembershipInitializer), "Start")]
namespace UserAuth.Filters
{

       
        public  class SimpleMembershipInitializer
        {
            public SimpleMembershipInitializer()
            {
                Database.SetInitializer<UsersContext>(null);

                try
                {
                    using (var context = new UsersContext())
                    {
                        if (!context.Database.Exists())
                        {
                            // Create the SimpleMembership database without Entity Framework migration schema
                            ((IObjectContextAdapter)context).ObjectContext.CreateDatabase();
                        }
                    }
                    
                    WebSecurity.InitializeDatabaseConnection("DefaultConnection", "UserProfile", "UserId", "UserName", autoCreateTables: true);
                    CreateAdminAccount();
                }
                catch (Exception ex)
                {
                    throw new InvalidOperationException("The ASP.NET Simple Membership database could not be initialized. For more information, please see http://go.microsoft.com/fwlink/?LinkId=256588", ex);
                }
            }

            private void CreateAdminAccount()
            {
                if (!WebSecurity.UserExists("admin"))
                {
                    WebSecurity.CreateUserAndAccount("admin", "123456");
                    var roleProvider = (SimpleRoleProvider)Roles.Provider;
                    if (!roleProvider.RoleExists("admin"))
                    {
                        roleProvider.CreateRole("admin");
                    }
                    roleProvider.AddUsersToRoles(new[] { "admin" }, new[] { "admin" });
                }
            }

            public static void Start()
            {
                new SimpleMembershipInitializer();
            }
        }
    
}
