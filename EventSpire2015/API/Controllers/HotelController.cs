using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNet.Mvc;

namespace API.Controllers
{
    [Route("api/[controller]")]
    public class HotelController : Controller
    {
        // POST api/values
        [HttpGet]
        public string Get(string longitude, string latitude, string radius, string startDate)
        {
            string json = System.IO.File.ReadAllText(@"C:\code\thack2015\JSONSamples\HotelStayResponse.json");
            return json;
        }

    }
}
