using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNet.Mvc;

namespace API.Controllers
{
    [Route("api/[controller]")]
    public class SearchController : Controller
    {
        // GET http://localhost:50362/api/search?userLongitude=1&userLatitude=2&eventCategory=3
        [HttpGet]
        public string Get(string userLongitude, string userLatitude, string eventCategory)
        {
            string json = System.IO.File.ReadAllText(@"C:\code\thack2015\JSONSamples\FlightScheduleRequest.json");
            return json;
        }
        
    }
}
