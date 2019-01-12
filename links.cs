using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace Linker
{
    #region Links
    public class Links
    {
        #region Member Variables
        protected int _id;
        protected string _url_short;
        protected string _url_real;
        #endregion
        #region Constructors
        public Links() { }
        public Links(string url_short, string url_real)
        {
            this._url_short=url_short;
            this._url_real=url_real;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Url_short
        {
            get {return _url_short;}
            set {_url_short=value;}
        }
        public virtual string Url_real
        {
            get {return _url_real;}
            set {_url_real=value;}
        }
        #endregion
    }
    #endregion
}