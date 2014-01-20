using System.Linq;
using System.Collections.Generic;
using ServiceStack;
using System;
using WebMatrix.WebData;
using System.Web.Security;
using UserAuth.Models;
using UserAuth.Filters;

namespace UserAuth
{

    public class UserData
    {
        public string Username { get; set; }
        public string Password { get; set; }

    }

    public class UserDataResponse
    {

        public List<DateTime> LoginTime { get; set; }

        public DateTime[] Result { get; set; }
        public ResponseStatus ResponseStatus { get; set; } //Where Exceptions get auto-serialized
    }

    
    public class LoginDataService : Service
    {
        public object Any(UserData request)
        {
            var membershipProvider = (SimpleMembershipProvider)Membership.Provider;

            if (WebSecurity.Login(request.Username, request.Password))
            {
                using (UsersContext db = new UsersContext())
                {
                    var userProfile = db.UserProfiles.FirstOrDefault(up => up.UserName == request.Username);
                    var logs = db.LoginLog.Where(log => log.UserId == userProfile.UserId).Select(ll=>ll.LoginDate);
                    var last10 = logs.OrderByDescending(x=>x).Skip(Math.Max(0, logs.Count() - 10)).Take(10).ToList();
                    var response = new UserDataResponse();
                    response.Result = last10.ToArray();
                    response.ResponseStatus = new ResponseStatus();
                    response.LoginTime = last10.ToList();
                    return response;
                }
            }

            return new UserDataResponse();
        }

        private long ConvertToTimestamp(DateTime value)
        {
            long epoch = (value.Ticks - 621355968000000000) / 10000000;
            return epoch;
        }
    }




    /*  Example calling above Service with ServiceStack's C# clients:

        var client = new JsonServiceClient(BaseUri);
        List<Todo> all = client.Get(new Todos());           // Count = 0

        var todo = client.Post(
            new Todo { Content = "New TODO", Order = 1 });      // todo.Id = 1
        all = client.Get(new Todos());                      // Count = 1

        todo.Content = "Updated TODO";
        todo = client.Put(todo);                            // todo.Content = Updated TODO

        client.Delete(new Todos(todo.Id));
        all = client.Get(new Todos());                      // Count = 0

    */

}
